<h2>Partials</h2>

<p>Makes it easy for a theme to reuse sections of code in a easy to overload way for child themes.
 
Includes the named template part for a theme or if a name is specified then a specialised part will be included. If the theme contains no {slug}.php file then no template will be included.
   
The template is included using require, not require_once, so you may include the same template part multiple times.</p>
<a href="https://developer.wordpress.org/reference/functions/get_template_part/">get_template_part() </a>

