# wp-plugin-icon-manager
Simple icon manager for my wordpress project

I needed sth like that in my wordpress project. new to wordpress plugins. Say you want to display 
i class="bi bi-dash-circle" with proper tags


You need to do 2 things
- set_icon("circle", "bi bi-dash-circle")
- echo get_icon("circle")

You set icon once. Its saved in custom table (prefix_icons). You can output anywhere. kinda like get_option. You get i class="bi bi-dash-circle" with proper tags.
PS. this md format is really hard to edit. Back in the day you could display code blocks easily.

