<form action="index.php?page=<?= $page ?>" 
      method="POST" 
      class="enterForm">

    <span>Sing in</span>  
    <?php showMessage('message') ?>  
    
    <input type="email"    
           name="entreEmail" 
           placeholder="Enter your email"
           class="form-control <?= checkInput('entreEmail') ? 'is-invalid' : '' ?> " >

    <?php if( checkInput('entreEmail') ): ?>
        <div class="invalid-feedback">Email is required!</div>
    <?php endif ?>

    <input type="password" 
           name="password"   
           placeholder="Password"
           class="form-control <?= checkInput('password') ? 'is-invalid' : '' ?> " >

    <?php if(checkInput('password')): ?>
        <div class="invalid-feedback">Password is required!</div>
    <?php endif ?>   

    <input type="hidden"   
           name="action"     
           value="sendFormSingIn">
           
    <button>Sing in</button>
</form> 


      
