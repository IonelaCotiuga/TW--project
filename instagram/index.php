<!DOCTYPE html>
<html lang="en">
  <head>
    <title>My Photo App</title>
  </head>

  <body>
    <?php
    require_once('instagram_basic_display_api.php');

    $params = array(
      'get_code' => isset($_GET['code']) ? $_GET['code'] : '',
    );
    $ig = new instagram_basic_display_api($params);
     ?>
    <?php if($ig->hasUserAccessToken): ?>
      <h4>IG Info</h4>
      <hr/>

      <!-- <h6>Access Token</h6>
      <?php //echo $ig->getUserAccessToken(); ?>
      <h6>Expires in</h6>
      <?php //echo ceil($ig->getUserAccessTokenExpires() / 86400); ?> days
      </hr>

      <?php $user = $ig->getUser(); ?>
      <pre>
        <?php //print_r($user); ?>
      </pre> -->

      <h1>Username: <?php echo $user['username']; ?></h1>
    	<h2>IG ID: <?php echo $user['id']; ?></h2>
    	<h3>Media Count: <?php echo $user['media_count']; ?></h3>
    	<h4>Account Type: <?php echo $user['account_type']; ?></h4>
      <hr/>

      <?php $usersMedia = $ig->getUsersMedia(); ?>
      <h3>User's Media (<?php echo count($usersMedia['data']); ?>)</h3>
      <!-- <h4>Raw Data</h4>
      <textarea style="width:100%;height:400px;"><?//php print_r($usersMedia['data']); ?></textarea> -->
      <h4>Posts</h4>
      <ul style="list-style: none; margin:0px; padding:0px;">
    		<?php foreach($usersMedia['data'] as $post):
                if($post['media_type'] == 'VIDEO'):
                  continue;
                endif;
        ?>
    			<li style="margin-bottom:20px;border:3px solid #333">
    				<div>
    					<img style="height:320px" src="<?php echo $post['media_url']; ?>" />
    				</div>
    				<div>
    					<b>Caption: <?php
                            if(isset($post['caption'])):
                              echo $post['caption'];
                            else:
                              echo '';
                            endif;
                          ?></b>
    				</div>
    				<div>
    					ID: <?php echo $post['id']; ?>
    				</div>
    				<div>
    					Media Type: <?php echo $post['media_type']; ?>
    				</div>
    				<div>
    					Media URL: <?php echo $post['media_url']; ?>
    				</div>
    			</li>
    		<?php endforeach; ?>
    	</ul>

    <?php else: ?>
      <h1>Error - not connected to an Instagram account.</h1>
    <?php endif; ?>
  </body>

</html>
