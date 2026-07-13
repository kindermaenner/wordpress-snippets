# Dynamic Tournament Menu

This snippet automatically adds current tournament pages to the WordPress navigation menu.

## The problem

Club websites often have recurring events that receive a new page every year:

* Blitz Championship 2024
* Blitz Championship 2025
* Blitz Championship 2026
* ...

The current tournament page should always be easy to find. However, manually updating the menu every year is easy to forget and creates unnecessary maintenance work.

## The solution

This snippet dynamically adds menu entries based on tournament metadata stored in WordPress.

It:

* searches for tournament pages created by our tournament plugins
* identifies the newest page based on the stored year
* adds the current tournament automatically to the navigation
* adds a link to the complete tournament archive

When a new tournament page is created, the menu updates automatically.

## Requirements

This snippet relies on metadata created by our own WordPress plugins:

* [monatsblitz-wp-plugin](https://github.com/kindermaenner/monatsblitz-wp-plugin)
* [swisschess-wp-plugin](https://github.com/kindermaenner/swisschess-wp-plugin)

These plugins create the tournament pages and store the year information used by this snippet.

For the historical overview, see:

* [tournament_archive](../tournament_archive)

## Configuration

The snippet currently expects a WordPress menu location called:

```text
primary
```

and adds the dynamic entries below the existing menu item:

```text
Schach spielen
```

Adjust these values to match your own menu structure.

## Background

This solution was developed for a small chess club website with recurring annual tournaments. The goal was to keep the navigation current without manual maintenance while preserving access to the complete tournament history.
