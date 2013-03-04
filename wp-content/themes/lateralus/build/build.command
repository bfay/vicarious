cd `dirname $0`
juicer merge -i ../js/vicarious.slideshow.js ../js/simplebox.js ../js/main.js --force -o ../js/lateralus.js -c none -m closure_compiler
echo "/* 
Theme Name:     Lateralus
Theme URI:      http://www.byronfay.com/themes 
Description:    Child theme for the Vicarious theme  
Author:         Byron Fay 
Author URI:     http://www.byronfay.com 
Template:       vicarious  
Version:        0.1.0 
License:		Creative Commons Share Alike 3.0
License URI:	http://creativecommons.org/licenses/by-sa/3.0/us/
Tags: brown, red, white, two-columns, fixed-width, sticky-post, custom-menu 
*/"|cat - ../style.css > /tmp/out && mv /tmp/out ../style.css