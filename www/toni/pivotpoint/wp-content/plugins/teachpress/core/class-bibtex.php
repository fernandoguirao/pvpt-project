<?php

/**
 * teachPress BibTeX | HTML class
 *
 * @since 3.0.0
 */
class tp_bibtex {
     
    var $row;
    var $settings;
    var $all_tags;
    var $url;
    var $input;

    /**
    * Get a single publication in bibtex format
    * @param ARRAY $row
    * @param ARRAY $all_tags (optional)
    * @return STRING 
    */
    function get_single_publication_bibtex ($row, $all_tags = '') {
        $string = '';
        $pub_fields = array('type', 'bibtex', 'name', 'author', 'editor', 'title', 'note', 'url', 'isbn', 'date', 'booktitle', 'journal', 'volume', 'number', 'pages', 'publisher', 'address', 'edition', 'chapter', 'institution', 'organization', 'school', 'series', 'crossref', 'abstract', 'howpublished', 'key', 'techtype', 'note');

        $string = '@' . stripslashes($row['type']) . '{' . stripslashes($row['bibtex']) . ',' . chr(13) . chr(10);
        for ( $i = 2; $i< count($pub_fields); $i++ ) {
            if ( $pub_fields[$i] == 'author' || $pub_fields[$i] == 'name' ) {
                $row[$pub_fields[$i]] = tp_bibtex::replace_html_chars($row[$pub_fields[$i]]);
            }
            // prepare single lines
            if ( isset( $row[$pub_fields[$i]] ) ) {  
                // ISBN | ISSN
                if ( $pub_fields[$i] == 'isbn' ) {
                    if ( $row['is_isbn'] == 1 && $row[$pub_fields[$i]] != '' ) {
                        $string = $string . 'isbn = {' . $row[$pub_fields[$i]] . '},' . chr(13) . chr(10);
                    }
                    if ( $row['is_isbn'] == 0 && $row[$pub_fields[$i]] != '' ) {
                        $string = $string . 'issn = {' . $row[$pub_fields[$i]] . '},' . chr(13) . chr(10);
                    }
                }
                // Year
                elseif ( $pub_fields[$i] == 'date' ) {
                    $preg = '/[\d]{2,4}/'; 
                    $time = array(); 
                    preg_match_all($preg, $row[$pub_fields[$i]], $time);
                    $string = $string . 'year  = {' . $time[0][0] . '},' . chr(13) . chr(10);
                    $string = $string . tp_bibtex::prepare_bibtex_line($row[$pub_fields[$i]],$pub_fields[$i]);
                }
                // Change publication type to bibtex type
                elseif ( $pub_fields[$i] == 'type' ) {
                    if ($row[$pub_fields[$i]] == 'presentation') {$row[$pub_fields[$i]] = 'misc';}
                    $string = $string . tp_bibtex::prepare_bibtex_line($row[$pub_fields[$i]],$pub_fields[$i]);
                }
                // normal case
                else {
                    $string = $string . tp_bibtex::prepare_bibtex_line($row[$pub_fields[$i]],$pub_fields[$i]);
                }
            }
        }
        if ( $all_tags != '' ) {
            $keywords = '';
            foreach ( $all_tags as $all_tags ) {
                $keywords = $keywords . $all_tags['name'] . ', ';
            }
            $keywords = substr($keywords, 0, -2);
            $string = $string . 'keywords = {' . $keywords . '}' . chr(13) . chr(10);
        }     
        $string = $string . '}' . chr(13) . chr(10);
        return $string;
    }

    /**
    * Get a single publication in html format
    * @param ARRAY $row
    * @param ARRAY $all_tags
    * @param ARRAY $url
    * @param ARRAY $settings
    * @return STRING
    */
    function get_single_publication_html ($row, $all_tags, $url, $settings) {
    $tag_string = '';
    $str = "'";
    $keywords = '';
    // show tags
    if ( $settings['with_tags'] == 1 ) {
        if ( $url["permalink"] == 1 ) {
            $href = $url["link"] . '?';
        }
        else {
            $href = $url["link"] . '?p=' . $url["post_id"] . '&amp;';
        }
        foreach ($all_tags as $tag) {
            if ($tag["pub_id"] == $row['pub_id']) {
                $keywords[] = array('name' => stripslashes($tag["name"]));
                $tag_string = $tag_string . '<a href="' . $href . 'tgid=' . $tag["tag_id"] . $settings['html_anchor'] . '" title="' . __('Show all publications which have a relationship to this tag','teachpress') . '">' . stripslashes($tag["name"]) . '</a>, ';
            }
        }
        $tag_string = substr($tag_string, 0, -2);
    }
    // handle images
    $image_marginally = '';
    $image_bottom = '';
    $td_left = '';
    $td_right = '';
    if ($settings['image'] == 'left' || $settings['image'] == 'right') {
        if ($row['image_url'] != '') {
            $image_marginally = '<img name="' . $row['name'] . '" src="' . $row['image_url'] . '" width="' . ($settings['pad_size'] - 5) .'" alt="' . $row['name'] . '" />';
        }
    }
    if ($settings['image'] == 'left') {
        $td_left = '<td width="' . $settings['pad_size'] . '">' . $image_marginally . '</td>';
    }
    if ($settings['image'] == 'right') {
        $td_right = '<td width="' . $settings['pad_size']  . '">' . $image_marginally . '</td>';
    }
    if ($settings['image'] == 'bottom') {
        if ($row['image_url'] != '') {
            $image_bottom = '<div class="tp_pub_image_bottom"><img name="' . stripslashes($row['name']) . '" src="' . $row['image_url'] . '" style="max-width:' . ($settings['pad_size']  - 5) .'px;" alt="' . stripslashes($row['name']) . '" /></div>';
        }
    }
    // transform URL into full HTML link
    if ($row['rel_page'] != 0) {
        $name = '<a href="' . get_permalink($row['rel_page']) . '">' . $row['name'] . '</a>';
    }
    else {
        $name = $row['name'];
    }

    // parse author names
    $all_authors = tp_bibtex::parse_author($row['author'], $settings['author_name'] );

    // language sensitive publication type
    $type = tp_translate_pub_type($row['type']);

    $a2 = '';
    $a3 = '';
    $abstract = '';
    $url = '';

    // if is abstract
    if ( $row['abstract'] != '' ) {
        $abstract = '<a id="tp_abstract_sh_' . $row['pub_id'] . '" class="tp_show" onclick="teachpress_pub_showhide(' . $str . $row['pub_id'] . $str . ',' . $str . 'tp_abstract' . $str . ')" title="' . __('Show abstract','teachpress') . '" style="cursor:pointer;">' . __('Abstract','teachpress') . '</a> | ';
    }
    // if are links
    if ( $row['url'] != '' ) {
        if ( $settings['link_style'] == 'inline' ) {
            $url = '<a id="tp_links_sh_' . $row['pub_id'] . '" class="tp_show" onclick="teachpress_pub_showhide(' . $str . $row['pub_id'] . $str . ',' . $str . 'tp_links' . $str . ')" title="' . __('Show links and resources','teachpress') . '" style="cursor:pointer;">' . __('Links','teachpress') . '</a> | ';
        }
        else {
            $url = ' | ' . __('Links','teachpress') . ': ' . tp_bibtex::prepare_url($row['url'], 'enumeration') . '';
        }
    }
    // if with tags
    if ($settings['with_tags'] == '1') {
        $tag_string = ' | ' . __('Tags') . ': ' . $tag_string;
    }
    // link style
    if ( $settings['link_style'] == 'inline' ) {
        $a2 = $abstract . $url . '<a id="tp_bibtex_sh_' . $row['pub_id'] . '" class="tp_show" onclick="teachpress_pub_showhide(' . $str . $row['pub_id'] . $str . ',' . $str . 'tp_bibtex' . $str . ')" style="cursor:pointer;" title="' . __('Show BibTeX entry','teachpress') . '">' . __('BibTeX','teachpress') . '</a>' . $tag_string;
    }
    else {
        $a2 = $abstract . '<a onclick="teachpress_pub_showhide(' . $str . $row['pub_id'] . $str . ',' . $str . 'tp_bibtex' . $str . ')" style="cursor:pointer;" title="' . __('Show BibTeX entry','teachpress') . '">' . __('BibTeX','teachpress') . '</a>' . $tag_string . $url;
    }
    // different styles: simple and normal
    if ($settings['style'] == 'simple') {
        $in = $row['editor'] != '' ? '' . __('In','teachpress') . ': ' : '';
        $a1 = '<tr class="tp_publication_simple">';
        $a1 = $a1 . $td_left;
        $a1 = $a1 . '<td class="tp_pub_info_simple">';
        $a1 = $a1 . '<span class="tp_pub_author_simple">' . stripslashes($all_authors) . '</span> ';
        $a1 = $a1 . '<span class="tp_pub_year_simple">(' . $row['jahr'] . ')</span>: ';
        $a1 = $a1 . '<span class="tp_pub_title_simple">' . stripslashes($name) . '.</span>';
        $a1 = $a1 . '<span class="tp_pub_additional_simple">' . $in . tp_bibtex::single_publication_meta_row($row, $settings) . '</span>';
        $a2 = ' <span class="tp_pub_tags_simple">(' . __('Type') . ': <span class="tp_pub_typ_simple">' . stripslashes($type) . '</span> | ' . $a2 . '</span>';
    }
    else {
        $a1 = '<tr class="tp_publication">';
        $a1 = $a1 . $td_left;
        $a1 = $a1 . '<td class="tp_pub_info">';
        $a1 = $a1 . '<p class="tp_pub_author">' . stripslashes($all_authors) . '</p>';
        $a1 = $a1 . '<p class="tp_pub_title">' . stripslashes($name) . ' <span class="tp_pub_typ">(' . stripslashes($type) . ')</span></p>';
        $meta_row = tp_bibtex::single_publication_meta_row($row, $settings);
        if ($meta_row != '.') {
            $a1 = $a1 . '<p class="tp_pub_additional">' . $meta_row . '</p>';
        }
        $a2 = '<p class="tp_pub_tags">(' . $a2 . ')</p>';
    }
    // end styles

    // div bibtex
    $a3 = '<div class="tp_bibtex" id="tp_bibtex_' . $row['pub_id'] . '" style="display:none;">';
    $a3 = $a3 . '<div class="tp_bibtex_entry">' . nl2br(tp_bibtex::get_single_publication_bibtex($row, $keywords)) . '</div>';
    $a3 = $a3 . '<p class="tp_close_menu"><a class="tp_close" onclick="teachpress_pub_showhide(' . $str . $row['pub_id'] . $str . ',' . $str . 'tp_bibtex' . $str . ')">' . __('Close','teachpress') . '</a></p>';
    $a3 = $a3 . '</div>';
    // div abstract
    if ( $row['abstract'] != '' ) {
        $a3 = $a3 . '<div class="tp_abstract" id="tp_abstract_' . $row['pub_id'] . '" style="display:none;">';
        $a3 = $a3 . '<div class="tp_abstract_entry">' . nl2br(stripslashes($row['abstract'])) . '</div>';
        $a3 = $a3 . '<p class="tp_close_menu"><a class="tp_close" onclick="teachpress_pub_showhide(' . $str . $row['pub_id'] . $str . ',' . $str . 'tp_abstract' . $str . ')">' . __('Close','teachpress') . '</a></p>';
        $a3 = $a3 . '</div>';
    }
    // div links
    if ( $row['url'] != '' && $settings['link_style'] == 'inline' ) {
        $a3 = $a3 . '<div class="tp_links" id="tp_links_' . $row['pub_id'] . '" style="display:none;">';
        $a3 = $a3 . '<div class="tp_links_entry">' . tp_bibtex::prepare_url($row['url'], 'list') . '</div>';
        $a3 = $a3 . '<p class="tp_close_menu"><a class="tp_close" onclick="teachpress_pub_showhide(' . $str . $row['pub_id'] . $str . ',' . $str . 'tp_links' . $str . ')">' . __('Close','teachpress') . '</a></p>';
        $a3 = $a3 . '</div>';
    }
    $a4 = $image_bottom . '
            </td>
            ' . $td_right . '
            </tr>';			
    $a = $a1 . $a2 . $a3 . $a4;			
    return $a;
    }

    /**
    * Get the second line of the publications with editor, year, volume, address, edition, etc.
    * @param ARRAY $row
    * @param ARRAY $settings
    * @return STRING
    */
    function single_publication_meta_row($row, $settings) {
    // For ISBN or ISSN number
    if ( $row['isbn'] != '' ) {
        // test if ISBN or ISSN
        if ($row['is_isbn'] == '0') { 
            $isbn = ', ISSN: ' . $row['isbn'] . '';
        }
        else {
            $isbn = ', ISBN: ' . $row['isbn'] . '';
        }
    }
    else {
        $isbn = '';
    }
    // Editor
    if ( $row['editor'] != '' ) {  
        $editor = tp_bibtex::parse_author($row['editor'], $settings['editor_name']);
        $editor = '' . $editor . ' (' . __('Ed.','teachpress') . '): ';
    }
    else {
        $editor = '';
    }
    // Rest of the fields
    $year = isset( $row['jahr'] ) ? $year = tp_bibtex::prepare_html_line($row['jahr']) : '';
    $booktitle = isset( $row['booktitle'] ) ? $booktitle = tp_bibtex::prepare_html_line($row['booktitle'],'',', ') : '';
    $journal = isset( $row['journal'] ) ? $journal = tp_bibtex::prepare_html_line($row['journal'],'',', ') : '';
    $volume = isset( $row['volume'] ) ? $volume = tp_bibtex::prepare_html_line($row['volume'],'',', ') : '';
    $number = isset( $row['number'] ) ? $number = tp_bibtex::prepare_html_line($row['number'],'',', ') : '';
    $pages = isset( $row['pages'] ) ? $pages = tp_bibtex::prepare_html_line($row['pages'],'' . __('Page(s)','teachpress') . ': ',', ') : '';
    $publisher = isset( $row['publisher'] ) ? $publisher = tp_bibtex::prepare_html_line($row['publisher'],'',', ') : '';
    $address = isset( $row['address'] ) ? $address = tp_bibtex::prepare_html_line($row['address'],'',', ') : '';
    $edition = isset( $row['edition'] ) ? $edition = tp_bibtex::prepare_html_line($row['edition'],'',', ') : '';
    $chapter = isset( $row['chapter'] ) ? $chapter = tp_bibtex::prepare_html_line($row['chapter'],'',' ') : '';
    $institution = isset( $row['institution'] ) ? $institution = tp_bibtex::prepare_html_line($row['institution'],'',' ') : '';
    $organization = isset( $row['organization'] ) ? $organization = tp_bibtex::prepare_html_line($row['organization'],'',' ') : '';
    $school = isset( $row['school'] ) ? $school = tp_bibtex::prepare_html_line($row['school'],'',', ') : '';
    $series = isset( $row['series'] ) ? $series = tp_bibtex::prepare_html_line($row['series'],'',' ') : '';
    $howpublished = isset( $row['howpublished'] ) ? $howpublished = tp_bibtex::prepare_html_line($row['howpublished'],'',' ') : '';
    $techtype = isset( $row['techtype'] ) ? $techtype = tp_bibtex::prepare_html_line($row['techtype'],'',' ') : '';

    // end format after type
    if ($row['type'] == 'article') {
        $end = $journal . $volume . $number . $pages . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'book') {
        $end = $edition . $publisher . $address . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'booklet') {
        $end = $howpublished . $address . $edition . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'conference') {
        $end = $booktitle . $year . $volume . $number . $series . $publisher . $address . $isbn . '.';
    }
    elseif ($row['type'] == 'inbook') {
        $end = $editor . $booktitle . $volume . $pages . $publisher . $address . $edition . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'incollection') {
        $end = $editor . $booktitle . $publisher . $isbn . '.';
    }
    elseif ($row['type'] == 'inproceedings') {
        $end = $editor . $booktitle . $pages . $address . $publisher . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'manual') {
        $end = $editor . $address. $edition . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'mastersthesis') {
        $end = $school . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'misc') {
        $end = $journal . $volume . $howpublished . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'phdthesis') {
        $end = $school . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'presentation') {
        $end = $howpublished . $row['address'] . '.';
    }
    elseif ($row['type'] == 'proceedings') {
        $end = $howpublished . $address . $edition . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'techreport') {
        $end = $school . $institution . $address . $number . $year . $isbn . '.';
    }
    elseif ($row['type'] == 'unpublished') {
        $end = $year . $isbn . '.';
    }
    else {
        $end = $row['jahr'] . '.';
    }
    $end = stripslashes($end);
    return $end;
    }
    /**
    * Import a BibTeX String
    * @global $PARSEENTRIES (CLASS)
    * @param STRING $input 
    * @param ARRAY $settings --> with index names: keyword_separator, author_format
    */
    function import_bibtex ($input, $settings) {
        global $PARSEENTRIES;
        // Replace bibtex chars and secure the input parameter
        $input = tp_bibtex::replace_bibtex_chars($input);
        // Parse a bibtex PHP string
        $parse = NEW PARSEENTRIES();
        $parse->expandMacro = TRUE;
        $array = array("RMP" => "Rev., Mod. Phys.");
        $parse->loadStringMacro($array);
        $parse->loadBibtexString($input);
        $parse->extractEntries();
        list($preamble, $strings, $entries, $undefinedStrings) = $parse->returnArrays();
        echo '<p><strong>' . __('Imported Publications:','teachpress') . '</strong></p>';
        for ($i = 0; $i < count($entries); $i++) {
            $number = $i + 1;
            // for the date of publishing
            if ( $entries[$i]['date'] != '' ) {
                $entries[$i]['date'] = $entries[$i]['date'];
            }
            elseif ($entries[$i]['month'] != '' && $entries[$i]['day'] != '' && $entries[$i]['year'] != '') {
                $entries[$i]['date'] = $entries[$i]['year'] . '-' . $entries[$i]['month'] . '-' . $entries[$i]['day'];
            }
            else {
                $entries[$i]['date'] = $entries[$i]['year'] . '-01-01';
            }
            // for tags
            if ($entries[$i]['keywords'] != '') { 
                $tags = str_replace($settings['keyword_separator'],",",$entries[$i]['keywords']);   
            }
            elseif ($entries[$i]['tags'] != '') {
                $tags = str_replace($settings['keyword_separator'],",",$entries[$i]['tags']);
            }
            else {
                $tags = '';
            }
            // for name
            if ($entries[$i]['name'] == '') {
                $entries[$i]['name'] = $entries[$i]['title'];
            }
            // for author / editor
            // for format lastname1, firstname1 and lastname2, firstname2
            if ($settings['author_format'] == 2) {
                $end = '';
                $new = explode(' and ', $entries[$i]['author'] );
                foreach ( $new as $new ) {
                    $parts = explode(',', $new); 
                    $num = count($parts); 
                    $one = ''; 
                    for ($j = 1; $j < $num; $j++) {
                        $parts[$j] = trim($parts[$j]);
                        $one = $one . ' '. $parts[$j];
                    }
                    $one = $one . ' ' . trim($parts[0]);
                    $end = $end != '' ? $end . ' and ' . $one : $one;
                }
                $entries[$i]['author'] = $end;
            }
            // add in database
            $entries[$i]['type'] = $entries[$i]['bibtexEntryType'];
            $entries[$i]['bibtex'] = $entries[$i]['bibtexCitation'];
            $new_entry = tp_add_publication($entries[$i], $tags, '');
            // return for user
            echo '<p>(' . $number . ') <a href="admin.php?page=teachpress/addpublications.php&amp;pub_ID=' . $new_entry . '" target="_blank">' . $entries[$i]['bibtexEntryType'] . ': ' . $entries[$i]['author'] . ' (' . $entries[$i]['year'] . '): ' . $entries[$i]['name'] . '</a></p>';
        }

    }

    /**
    * Replace some HTML special chars with the UTF-8 versions
    * @param STRING $input
    * @return STRING $input
    */
    function replace_html_chars ($input) {
        $array_1 = array('&Uuml;','&uuml;', '&Ouml;', '&ouml;', '&Auml;','&auml;', '&nbsp;', '&szlig;', '&sect;', '&ndash;', '&rdquo;', '&ldquo;', '&eacute;', '&egrave;', '&aacute;', '&agrave;', '&ograve;','&oacute;', '&copy;', '&reg;', '&micro;', '&pound;', '&raquo;', '&laquo;', '&yen;', '&Agrave;', '&Aacute;', '&Egrave;', '&Eacute;', '&Ograve;', '&Oacute;', '&shy;', '&amp;');
        $array_2 = array('Ü','ü', 'Ö', 'ö', 'Ä', 'ä', ' ', 'ß', '§', '-', '”', '“', 'é', 'è', 'á', 'à', 'ò', 'ó', '©', '®', 'µ', '£', '»', '«', '¥', 'À', 'Á', 'È', 'É', 'Ò', 'Ó', '­', '&');
        $input = str_replace($array_1, $array_2, $input);
        return $input;
    }

    /**
    * Replace some BibTeX special chars with the UTF-8 versions and secure the parameter
    * @param STRING $input
    * @return STRING $input
    */
    function replace_bibtex_chars ($input) {
        $input = str_replace(chr(92),'',$input);
        $array_1 = array ('{"A}','{"a}','{"O}','{"o}','{ss}','{"U}','{"u}');
        $array_2 = array('Ä','ä','Ö','ö','ß','Ü','ü');
        $input = str_replace($array_1, $array_2, $input);
        $input = tp_sec_var($input);
        return $input;
    }

    /**
    * Prepare a single BibTeX line with the input from onde publication field
    * @param STRING $input - the value of the publication field
    * @param STRING $fieldname - the name of the publication field
    * @return STRING $input - the line
    */
    function prepare_bibtex_line($input, $fieldname) {
        if ($input != '') {
            $input = '' . $fieldname . ' = {' . stripslashes($input) . '},' . chr(13) . chr(10);
        }
        else {
            $input = '';
        }
        return $input;
    }

    /**
    * Prepare a single HTML line with the input from one publication field
    * @param STRING $input
    * @param STRING $before
    * @param STRING $after
    * @return STRING $input 
    */
    function prepare_html_line($input, $before = '', $after = '') {
        if ($input != '') {
            $input = $before . $input . $after;
        }
        else {
            $input = '';
        }
        return $input;
    }

    /**
    * Prepare a url link for publication resources 
    * @param STRING $url
    * @param STRING $mode     -> list or enumeration
    * @return string 
    */
    private function prepare_url($url, $mode = 'list') {
        $end = '';
        $url = explode(chr(13) . chr(10), $url);
        foreach ($url as $url) {
            $parts = explode(', ',$url);
            $parts[0] = trim( $parts[0] );
            $parts[1] = isset( $parts[1] ) ? $parts[1] : $parts[0];
            // list mode 
            if ( $mode == 'list' ) {
                $length = strlen($parts[1]);
                $parts[1] = substr($parts[1], 0 , 80);
                if ($length > 80) {
                    $parts[1] = $parts[1] . '[...]';
                }
                $end = $end . '<li><a class="tp_pub_list" style="background-image: url(' . get_tp_mimetype_images( $parts[0] ) . ')" href="' . $parts[0] . '" title="' . $parts[1] . '" target="_blank">' . $parts[1] . '</a></li>';
            }
            // enumeration mode
            else {
                $end = $end . '<a class="tp_pub_link" href="' . $parts[0] . '" title="' . $parts[1] . '" target="_blank"><img class="tp_pub_link_image" alt="" src="' . get_tp_mimetype_images( $parts[0] ) . '"/></a>';
            }
        }
        if ( $mode == 'list' ) {
            $end = '<ul class="tp_pub_list">' . $end . '</ul>';
        }
        return $end;
    }

    /**
    * Parse author names
    * @global $PARSECREATORS
    * @param STRING $input
    * @param STRING $mode --> values: last, initials, old
    * @return STIRNG 
    */
    function parse_author ($input, $mode = '') {
    global $PARSECREATORS;
    /* the new teachpress parsing
        * last: 	Adolf F. Weinhold and Ludwig van Beethoven --> Weinhold, Adolf; van Beethoven, Ludwig
        * initials: 	Adolf F. Weinhold and Ludwig van Beethoven --> Weinhold, Adolf F; van Beethoven, Ludwig
    */
    if ($mode == 'last' || $mode == 'initials') {
        $creator = new PARSECREATORS();
        $creatorArray = $creator->parse($input);
        $all_authors = "";
        for ($i = 0; $i < count($creatorArray); $i++) {
            $one_author = "";
            if ($mode == 'last' || $mode == 'initials') {
                if ($creatorArray[$i][3] != '') { $one_author = trim($creatorArray[$i][3]);}
                if ($creatorArray[$i][2] != '') { $one_author = $one_author . ' ' .trim($creatorArray[$i][2]) . ',';}
                if ($creatorArray[$i][0] != '') { $one_author = $one_author . ' ' .trim($creatorArray[$i][0]);}
                if ($mode == 'initials') { 
                    if ($creatorArray[$i][1] != '') { $one_author = $one_author . ' ' .trim($creatorArray[$i][1]);}
                }
                $all_authors = $all_authors . stripslashes($one_author);
                if ($i < count($creatorArray) -1) {$all_authors = $all_authors . '; ';}
            }
        }
    }
    /* the original (old) teachpress parsing
        * example: Adolf F. Weinhold and Ludwig van Beethoven --> Weinhold, Adolf F.; van Beethoven, Ludwig
    */
    elseif ($mode == 'old') {
        $all_authors = "";
        $one_author = "";
        $array = explode(" and ",$input);
        $lenth = count ($array);
        for ($i=0; $i < $lenth; $i++) {
            $array[$i] = trim($array[$i]);
            $names = explode(" ",$array[$i]);
            $lenth2 = count($names);
            for ($j=0; $j < $lenth2-1; $j++) {
                $one_author = $one_author . ' ' . trim( $names[$j] );
            }
            $one_author = trim( $names[$lenth2 - 1] ). ', ' . $one_author;
            $all_authors = $all_authors . $one_author;
            if ($i < $lenth - 1) {
                $all_authors = $all_authors . '; ';
            }
            $one_author = "";
        }
    }
    /* the simple teachpress_parsing
        * example: Adolf F. Weinhold and Albert Einstein --> Adolf F. Weinhold, Albert Einstein
    */
    else {
        $all_authors = str_replace(' and ', ', ', $input);
    }
    return $all_authors;
    }
}
?>