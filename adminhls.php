<?php
session_start();
if(!isset($_SESSION['logined'])){
    echo '<script>window.location.href="login.php"</script>';
}
?>
<div style="width:100%;text-align:center">Admin HSL<br>Notice of processing at the bottom of the page</div>
<form method="POST">
<fieldset style="border-color:green">
    <legend>Create File</legend>
    <input type="text" name="filename" placeholder="File Name"><br>
    <textarea type="text" name="filecontent" spellcheck="false" placeholder="File Content" style="margin-top:10px;width:100%;height:150px"></textarea><br>
    <button type="submit" name="btCreateFile" style="margin-top:10px">Submit</button>
</fieldset>
</form>

<form method="POST">
<fieldset style="border-color:blue">
    <legend>Create Folder or Handle Folder and File</legend>
    <input type="text" name="path" placeholder="Default: It will show current path if You don't type path !" style="width:40%"><br>
    <input type="radio" name="handleDirectory" value="createFolder">Create Folder<br>
    <input type="radio" name="handleDirectory" value="deleteFolder">Delete Folder<br>
    <input type="radio" name="handleDirectory" value="deleteFile">Delete File<br>
    <button type="submit" name="btCreateFolder" style="margin-top:10px">Submit</button>
</fieldset>
</form>

<form method="POST">
<fieldset style="border-color:blue">
    <legend>View Folder List</legend>
    <input type="text" name="path" placeholder="Default: It will show current path if You don't type path !" style="width:40%"><br>
    <button type="submit" name="btFolderList" style="margin-top:10px">Submit</button>
</fieldset>
</form>

<form method="POST">
<fieldset style="border-color:blue">
    <legend>View File</legend>
    <input type="text" name="path" placeholder="File Path" style="width:40%"><br>
    <button type="submit" name="btViewFile" style="margin-top:10px">Submit</button>
</fieldset>
</form>

<?php
    if(isset($_POST['btCreateFile'])){
        if(empty($_POST['filename']) || empty($_POST['filecontent'])){
            echo 'File name or File Content is empty !';
        }else{
            $filename = $_POST['filename'];
            $filecontent = $_POST['filecontent'];
            $file = fopen($filename, "w");
            fwrite($file, $filecontent);
            fclose($file);
            echo $_POST['filename'].' created successly';
        }
    }elseif(isset($_POST['btCreateFolder'])){
        if(empty($_POST['path'])){
            echo 'Path of Folder is empty !';
        }else{
            if($_POST['handleDirectory'] == 'createFolder'){
                if (!file_exists( $_POST['path'] )) { 
                    mkdir( $_POST['path'] , 0777, true); 
                    echo 'Create Folder is success !';
                }else{
                    echo 'The path already exists !';
                }
            }elseif($_POST['handleDirectory'] == 'deleteFolder'){
                function delete_directory($dirname) {
                    if (is_dir($dirname)){
                        $dir_handle = opendir($dirname);
                    }else {
                        echo "The path don't exists !";
                        return;
                    }
                    if (!$dir_handle)return false;

                    while($file = readdir($dir_handle)) {
                        if ($file != "." && $file != "..") {
                            if (!is_dir($dirname."/".$file))
                                    unlink($dirname."/".$file);
                            else
                                    delete_directory($dirname.'/'.$file);
                        }
                    }
                    closedir($dir_handle);
                    rmdir($dirname);
                    echo 'Delete Folder is success !';
                    return;
                }
                delete_directory($_POST['path']);
            }elseif($_POST['handleDirectory'] == 'deleteFile'){
                if(file_exists($_POST['path'])){
                    unlink($_POST['path']);
                    echo 'Delete File is success !';
                    return;
                }else{
                    echo "The path don't exists !";
                    echo file_exists($_POST['path']);
                    return;
                }
            }
        }
    }elseif(isset($_POST['btFolderList'])){
        $path = dirname(__FILE__);
        if(!empty($_POST['path'])){
            $path = dirname(__FILE__).'/'.$_POST['path'];
        }
        //show list
        function listFolderFiles($dir)
        {
            echo '<ol>';
            foreach (new DirectoryIterator($dir) as $fileInfo) {
                if (!$fileInfo->isDot()) {
                    echo '<li>' . $fileInfo->getFilename();
                    if ($fileInfo->isDir()) {
                        listFolderFiles($fileInfo->getPathname());
                    }
                    echo '</li>';
                }
            }
            echo '</ol>';
        }
        listFolderFiles($path);
        //end show list
    }elseif(isset($_POST['btViewFile'])){
        if(empty($_POST['path'])){
            echo 'File path is empty !';
        }else{
            $fileContent = htmlentities(file_get_contents($_POST['path']));
            echo '<br>';
            echo '
            <textarea type="text" spellcheck="false" style="margin-top:10px;width:100%;height:100%">'.$fileContent.'</textarea>
            ';
        }
    }  
?>