add_filter('wp_nav_menu_objects', function ($items, $args) {

    // theme_location anpassen, falls nötig
    if ($args->theme_location !== 'primary') {
        return $items;
    }

    $turniere = [
        'blitzmeisterschaft' => 'Blitzmeisterschaft',
        'stadtmeisterschaft' => 'Stadtmeisterschaft'
    ];

    // Elternpunkt "Schach spielen" finden
    $parent_id = null;
    foreach ($items as $item) {
        if ($item->title === 'Schach spielen') {
            $parent_id = $item->ID;
            break;
        }
    }
    if ($parent_id === null) {
        return $items;
    }

    // Neue dynamische Menüeinträge erzeugen
    $dynamic_items = [];

    foreach ($turniere as $slug => $label) {

        // aktuelle Seite finden
        $pages = get_posts([
            'post_type'  => 'page',
            'meta_key'   => '_' . $slug . '_year',
            'numberposts'=> -1,
        ]);
        if (empty($pages)) {
            continue;
        }

        usort($pages, function ($a, $b) use ($slug) {
            $yearA = intval(get_post_meta($a->ID, '_' . $slug . '_year', true));
            $yearB = intval(get_post_meta($b->ID, '_' . $slug . '_year', true));
            return $yearB <=> $yearA;
        });

        $current_page = $pages[0];

        // neues Menüobjekt erzeugen
        $menu_item = new WP_Post((object)[
            'ID' => rand(100000, 999999),
            'post_title' => $label,
            'post_name' => sanitize_title($label),
            'post_type' => 'nav_menu_item',
        ]);

        // WordPress Menüfelder setzen
        $menu_item->menu_item_parent = $parent_id;
        $menu_item->url = get_permalink($current_page->ID);
        $menu_item->title = $label;

        $dynamic_items[] = $menu_item;
    }

    // Dynamischen Menüpunkt "Turnierarchiv" erzeugen
    $archiv_item = new WP_Post((object)[
        'ID' => rand(100000, 999999),
        'post_title' => 'Turnierarchiv',
        'post_name' => 'turnierarchiv',
        'post_type' => 'nav_menu_item',
    ]);

    $archiv_item->menu_item_parent = $parent_id;
    $archiv_item->url = site_url('/turnierarchiv');
    $archiv_item->title = 'Turnierarchiv';

    $dynamic_items[] = $archiv_item;

    // Dynamische Items anhängen
    foreach ($dynamic_items as $new_item) {
        $items[] = $new_item;
    }

    return $items;

}, 10, 2);
