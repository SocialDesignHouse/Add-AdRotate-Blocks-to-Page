Add-AdRotate-Blocks-to-Page
===========================

Adds a options for dynamically adding AdRotate Blocks to WordPress pages.

This is a EXTREMELY BETA version of this plug-in extension.

It does not have all desired functionality implemented yet.

What is it?
-----------

This is a plug-in that extends the functionality of the AdRotate plug-in by 
creating an options page in the WordPress admin area that allows adminitrators
to define specific sections that they want to allow AdRotate blocks to be placed
inside of.

After setting up an AdRotate Ad Block Position in the options page, users can
select a Block from a dropdown of all created Blocks when editing pages.

You can create as many positions as you want, so if you site will have different
ads in a sidebar and footer area, you can define two positions for the user to
assign different blocks to when editing pages.

Why use it?
-----------

As a Theme developer, you can access the Blocks that a user wants to show up in
an Ad Block Position via custom post data.

The names of the Ad Block Positions that you define, become the custom post meta
key.

### For Example

Let's say on the options page I define one Ad Block Position called My Block Position.

So in a your page template:

    //get post custom meta data
    $custom = get_post_custom($post->ID);
    //get AdRotate Block ID with position of My Block Position
    $ad_block_id = $custom['my_block_position'][0];
    
Now, to display it in your template, use the built in AdRotate display functions.

    echo adrotate_block($ad_block_id);

Is that it?
-----------

For now.

But feel free to tweak it to suit your needs.

And make sure to check out the features coming soon below.
    
Coming Soon
------------

1. Toggle Positions between Ads, Groups, and Blocks.
2. Remove already saved post meta on uninstall.
3. Custom display function so post meta doesn't need to be retrieved manually.
4. Restrict access to specific Positions by User Level or capability.
5. Restrict access to creating and adding Positions by User Level or capability.
6. Delete Add Block Positions. (currently you need to deactivate the plug-in)
7. Plug-in saves Positions on deactivation.
