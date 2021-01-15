<form action="index.php?page=<?= $page ?>" 
      method="POST" 
      class="enterForm">

    <span>Sing up</span> 
    <?php showMessage('message') ?>  

    <input type="email"    
           name="newEmail"     
           placeholder="Enter your email"
           class="form-control <?= checkInput('newEmail') ? 'is-invalid' : '' ?> " >

    <?php if( checkInput('newEmail') ): ?>
        <div class="invalid-feedback">Email is required!</div>
    <?php endif ?>

    <input type="password" 
           name="newpassword"  
           placeholder="Password"
           class="form-control <?= checkInput('newpassword') ? 'is-invalid' : '' ?> " >

    <?php if( checkInput('newpassword') ): ?>
        <div class="invalid-feedback">Password too short</div>
    <?php endif ?>

    <input type="password" 
           name="repass"       
           placeholder="Repeat password"
           class="form-control <?= checkInput('repass') ? 'is-invalid' : '' ?> " >

    <?php if( checkInput('repass') ): ?>
        <div class="invalid-feedback">Passwords do not match!</div>
    <?php endif ?>
    
    <input type="hidden"   
           name="action"       
           value="sendFormSingUp">

    <button>Sing up</button>
</form> 

