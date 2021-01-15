<h1>Reviews</h1>
<?php showMessage('message') ?>

<form action="index.php" method="POST">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>
    <div class="form-group">
        <label for="review">Review</label>
        <textarea name="review" id="review" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="captcha">Captcha</label> <br>
        <img src="images-php/captcha.php" alt="">
        <input type="text" name="captcha" id="captcha" class="form-control">
    </div>

    
    <input type="hidden" name="action" value="saveReview">
    <button class="btn btn-primary">Send Review</button>
</form>

<h2>All Reviews</h2>
<?php showReview() ?>
