Отправка сообщений ВК<br><br>

<?php if(!empty($error_array)): ?>
        <span style="color: red;">Файл не загружен!</span><br/>
        <?php foreach($error_array as $one_error): ?>
            <span style="color: red;"><?=$one_error;?></span><br/>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if(empty($error_array) AND $_FILES): ?>
        <span style="color: green;">Файл успешно загружен!</span><br/>
    <?php endif; ?>
    <form action="vk_yuri_bot.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="upload_file"><br> 
		<input type="text" name="vk_mesage" value="test vk message"><br>
		<input type="text" name="vk_user_id" value="https://vk.com/yura_bogachev"><br>
		
        <input type="submit" value="Пошел!"><br><br>
		
    </form>
	
<br><br><input type="button" id="cancel"  value="Отмена" onClick="location.href='form.php'">