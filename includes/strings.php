<?php
// Error Strings
define('ERROR_CONNECTION_FAILED', 'Error: Connection to database failed.');
define('ERROR_VERIFICATION_FAILED', 'Error: Email verification failed.');
define('ERROR_INVALID_ACCESS', 'Error: File cannot be accessed directly.');
define('ERROR_USER_NONEXISTANT', 'That user doesn\'t exist.');


// Message Strings
define('MESSAGE_WELCOME_STRINGS', 'Welcome!/Aloha!/Hello!/Welcome back!/Hey!/Hi!/Bonjour!/Howdy!'); // andomly chosen from the list of strings separated by '/'
define('MESSAGE_NOT_REGISTERED', 'Haven\'t registered yet?  Do it <a href="signup.php">here</a>!');
define('MESSAGE_WELCOME_SIGNUP', 'Welcome to the site.  Just fill in the fields and you should be good to go!');
define('MESSAGE_USER_NONEXISTANT', 'That user doesn\'t exist.');
define('MESSAGE_USER_SENT', 'Email was sent.');
define('MESSAGE_CATEGORY_EMPTY', 'There are no topics in this category yet.');
define('MESSAGE_CATEGORY_SIGNOUT', 'Admins must be <a href="signin.php">signed in</a> to create a category.');
define('MESSAGE_CATEGORY_UNAUTHORIZED', 'You must be an admin to create a category.');
define('MESSAGE_CATEGORY_EXISTS', 'There is already a category with that name.');
define('MESSAGE_CATEGORY_NONEXISTANT', 'That category doesn\'t exist.');
define('MESSAGE_CATEGORY_SUCCESS', 'New category successfully added.');
define('MESSAGE_CATEGORY_EMPTY', 'All the fields must be filled in.');
define('MESSAGE_TOPIC_SIGNOUT', 'You must be <a href="signin.php">signed in</a> to create a topic.');
define('MESSAGE_TOPIC_CATEGORY', 'You have not created any categories yet.');
define('MESSAGE_TOPIC_SUPERCATEGORY', 'Before you can post a topic, an admin must create a category.');
define('MESSAGE_TOPIC_SUCCESS', 'You have successfully created <a href="topic.php?topic_id=%topic_id%&page=1">your new topic</a>.'); // %topic_id% is replaced with 
define('MESSAGE_TOPIC_EMPTY', 'All the fields must be filled in.');
define('MESSAGE_REPLY_SIGNOUT', 'You must be <a href="/login">signed in</a> to post a reply.');
define('MESSAGE_REPLY_EMPTY', 'All the fields must be filled in.');


// Short Strings
define('SHORT_USER_SIGNIN', 'Sign In');
define('SHORT_USER_REGISTER', 'Register');
define('SHORT_USER_USERNAME', 'Username');
define('SHORT_USER_PASSWORD', 'Password');
define('SHORT_USER_DESCRIPTION', 'Edit Profile');
define('SHORT_USER_OVERVIEW', 'Profile Overview');
define('SHORT_USER_SIGNOUT', 'Sign Out');
define('SHORT_USER_POSTS', 'Post Count');
define('SHORT_USER_JOINED', 'Joined');
define('SHORT_USER_', '');
define('SHORT_USER_', '');
define('SHORT_CATEGORY_CREATE', 'Create a Category');
define('SHORT_CATEGORY_NAME', 'Category name');
define('SHORT_CATEGORY_ADD', 'Add Category');
define('SHORT_TOPIC_CREATE', 'Create a Topic');
define('SHORT_TOPIC_BUTTON', 'Create Topic');
define('SHORT_TOPIC_SUBJECT', 'Topic subject');
define('SHORT_TOPIC_SINGULAR', 'topic');
define('SHORT_TOPIC_PLURAL', 'topics');
define('SHORT_NAV_HOME', 'Home');
?>
