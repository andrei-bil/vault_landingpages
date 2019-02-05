<?php require('partials/head.php'); ?>

<h1>User</h1>
<?php print_r($user); ?>



<form action="/users/delete" method="post">
   <input type="hidden" name="user-id" value="<?php echo $user[0]->id ?>"/>
   <button type="submit">Delete</button>
</form>

<?php require('partials/footer.php'); ?>
