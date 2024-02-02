# wp-plugin-icon-manager
Simple icon manager for my wordpress project

I needed sth like that in my wordpress project. new to wordpress plugins. Say you want to display 
i class="bi bi-dash-circle" with proper tags


You need to do 2 things
- set_icon("circle", "bi bi-dash-circle")
- echo get_icon("circle")
- **EDIT**: if theres no icon function already in use, plugin registers "icon" function that displays icon with proper html and class. you need to output icon('circle') for example to get icon that has label circle (set icon).
- **EDIT**: bug fixed - set icon sets record in db once. then if icon is set again (the same icon) it updates a row

You set icon once. Its saved in custom table (prefix_icons). You can output anywhere. kinda like get_option. You get i class="bi bi-dash-circle" with proper tags.
PS. this md format is really hard to edit. Back in the day you could display code blocks easily.

