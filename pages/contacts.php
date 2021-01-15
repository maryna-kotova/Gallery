<form action="index.php?page=<?= $page ?>" 
      method="POST" 
      class="enterForm contacts">

    <span>Contact us</span>
    <?php showMessage('message') ?>

    <input type="email" 
           name="email" 
           id="email" 
           placeholder="Enter your email"
           class="form-control <?= checkInput('message', 'email') ? 'is-invalid' : '' ?> " >

    <?php if( checkInput('message', 'email') ): ?>
        <div class="invalid-feedback">Email is required!</div>
    <?php endif ?>

    <textarea name="message"                   
              id="message"               
              placeholder="Message"></textarea>

    <input type="hidden" 
           name="action" 
           value="sendMessage">
    
    <button>Send</button>       
</form>