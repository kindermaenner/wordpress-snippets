function turnier_archiv_shortcode() {

    $turniere = [
        'blitzmeisterschaft' => 'Blitzmeisterschaft',
        'stadtmeisterschaft' => 'Stadtmeisterschaft'
    ];

    ob_start();

    foreach ($turniere as $slug => $label) {

        echo '<h2>' . esc_html($label) . '</h2>';

        // Alle Seiten finden, die den Year-Key haben
        $pages = get_posts([
            'post_type'  => 'page',
            'meta_key'   => '_' . $slug . '_year',
            'numberposts'=> -1,
        ]);

        if (empty($pages)) {
            echo '<p>Keine Seiten gefunden.</p>';
            continue;
        }

        // Nach Jahr sortieren (höchstes Jahr zuerst)
        usort($pages, function ($a, $b) use ($slug) {
            $yearA = intval(get_post_meta($a->ID, '_' . $slug . '_year', true));
            $yearB = intval(get_post_meta($b->ID, '_' . $slug . '_year', true));
            return $yearB <=> $yearA;
        });

        // Aktuelle Seite = höchste Jahreszahl
        $current_page = $pages[0];
        $current_year = intval(get_post_meta($current_page->ID, '_' . $slug . '_year', true));

        // Aktuelle Seite anzeigen
        echo '<p><strong>Aktuell: <a href="' . get_permalink($current_page->ID) . '">' 
            . esc_html($current_page->post_title) 
            . '</a></strong></p>';

        // Ältere Seiten anzeigen
        echo '<ul>';
        foreach ($pages as $page) {
            $year = intval(get_post_meta($page->ID, '_' . $slug . '_year', true));
            if ($year === $current_year) continue;

            echo '<li><a href="' . get_permalink($page->ID) . '">' 
                . esc_html($page->post_title) 
                . '</a></li>';
        }
        echo '</ul>';
    }

    return ob_get_clean();
}
add_shortcode('turnier_archiv', 'turnier_archiv_shortcode');
