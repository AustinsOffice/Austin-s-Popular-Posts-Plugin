Austin's Popular Posts Plugin for Wordpress
============================

A plugin for Wordpress that tracks post view counts and uses that data to list your most popular content.

I don't think I've ever created a Wordpress site without displaying my popular posts in some fashion. There's quite a few plugins out there that handle this pretty well, but I prefer to develop my own basic plugins so I only have what I need and nothing more.

## The Plugin

Austin's Popular Posts (super name, yeah?) is pretty much just the bare minimum required to get the functionality. All it does it adds a meta field to your posts called `post_views` and updates this field when a user views a post.

A widget with a few customization options is included for simplicity, but you can just get rid of that and use the included helper functions to generate your own list. 

## Helper Functions

A few functions are included to make using the plugin as simple as possible. As mentioned, this isn't necessary as you can just use the included widget, but if you want more control this is for you!

### Get a List

To generate a list, you'll be using the following:
```
<?php get_popular_posts($time, $amount_to_list, $list_type, $class); ?>
```

The first two parameters are required. `$time` is the time-span from which to draw posts. The time-span can be defined as `'1 ____ ago'`, so 'day', 'week', and 'month' are valid. Also, 'daily', 'weekly', and 'monthly' will be converted.

`$amount_to_list` is just a simple integer that will determine the number of posts to list. `$list_type` is looking for a 'ul' or 'ol' depending on how you want the items listed, and you can pass a custom CSS class to `$class` to add to your list.

### Get View Count

The next function is a simple way to grab or print the amount of a views a particular post has.

```
<?php view_count($id); ?>
```

This function will just return the number of views a specific post has based on the `$id`. If no `$id` is passed, it'll use the `global $post` ID which works fine for single posts. 

If you're calling this in a loop, though, you'll have to pass it specific IDs since `global $post` will be populated with the first post of the loop (I think?). 

Now if you're just wanting to print the view count on screen, the following echos the value instead of just returning it:

```
<?php get_view_count($id); ?>
```

The same applies regarding the `$id` parameter as above.

## The Widget
If it wasn’t for the widget being included, this package would be extremely, extremely small. But, I know a lot of people that might end up using this probably won’t be comfortable stumbling around in their theme files plopping the functions about.

If that sounds like something you don’t want to do, then you can just use the widget! The widget has pretty much the same options as doing it the “hard” way, but you lose a bit of control.

The options are self-explanatory, but just to be thorough I’ll touch on them. “When” is a select menu that allows you to choose a time-span from which to pull posts. Selecting ‘weekly’ will pull posts only from the past week for example.

‘Amount to display’ is literally the number of items you want listed. That’s it.

