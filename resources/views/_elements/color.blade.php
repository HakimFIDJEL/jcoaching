@php


if($primary_color) {
    // Change the root of --bs-primary & --primary
    echo "<style>:root { --bs-primary: $primary_color; --primary: $primary_color; }</style>";
}

if($secondary_color) {
    // Change the root of --bs-secondary & --secondary
    echo "<style>:root { --bs-secondary: $secondary_color; --secondary: $secondary_color; }</style>";
}

if($background_color) {
    // Change the root of --bs-background & --background
    echo "<style>:root { --bs-body-bg: $background_color; --background: $background_color; }</style>";
}

if($font_color) {
    // Change the root of --bs-font-color & --font-color
    echo "<style>:root { --bs-body-color: $font_color; --font-color: $font_color; }</style>";
}



@endphp