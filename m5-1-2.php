<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
    </style>
  </head>
  <body>
      
   <?php
    if(!empty($_POST["comment"]))
    if(!empty($_POST["name"]))
    {$comment = $_POST["comment"];
    $name=$_POST["name"];
    $pass = $_POST["pass"];
    $postedAt = date("Y年m月d日 H:i:s");
    
    }
    //DB is connected
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql = "CREATE TABLE IF NOT EXISTS tb10"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "pass char(32),"
    . "date char(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);
    ?>
  
  <?php
  //削除機能
  if (!empty($_POST['dnum']) && !empty($_POST['delpass'])) 
         {$delete = $_POST['dnum'];
          $delpass = $_POST['delpass'];
            $sql = 'SELECT * FROM tb10';
            $result = $pdo -> query($sql);
               foreach ($result as $row){
                if($row['id'] == $delete && $row['pass'] == $delpass)
                {$id = $delete;
                  $sql = 'delete from tb10 where id=:id';
                  $stmt = $pdo->prepare($sql);
                  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                  $stmt->execute();
                }elseif($row['id'] == $delete && $row['pass'] !== $delpass)
                  {echo "パスワードが違います";}
                }
  }  

//編集見極め機能
if (!empty($_POST['edit']) && !empty($_POST['editpass']))
  {$edit = $_POST['edit'];
   $editpass = $_POST['editpass'];
       $sql = 'SELECT * FROM tb10';
       $result = $pdo -> query($sql);
          foreach ($result as $row){
             if($row['id'] == $edit)
             {$editnumber = $row['id'];
              $editname = $row['name'];
              $editcomment = $row['comment'];
              $editpassword = $row['pass'];
             }
          }
  }
  
//編集機能
if (!empty($_POST['number']) && !empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['pass']))
   {$name = $_POST['name'];
    $number = $_POST['number'];
    $comment = $_POST['comment'];
    $pass = $_POST['pass'];
    $postedAt = date("Y年m月d日 H:i:s");
      $sql = 'SELECT * FROM tb10';
      $result = $pdo -> query($sql);
         foreach ($result as $row){
           if($row['id'] == $number)
              {$id = $number; //変更する投稿番号
              $name = $_POST['name'];
              $comment = $_POST['comment']; 
                   $sql = 'UPDATE tb10 SET name=:name,comment=:comment, date=:date, pass=:pass WHERE id=:id';
                   $stmt = $pdo->prepare($sql);
                   $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                   $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                   $stmt->bindValue(':date', $postedAt, PDO::PARAM_STR);
                   $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                   $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                   $stmt->execute();
              }              
          }                      
  }else{(!empty($_POST['name']));
    if(!empty($_POST['comment']) && !empty($_POST['pass']))
        {$postedAt = date("Y年m月d日 H:i:s");
        $stmt = $pdo->query($sql);
        $sql = $pdo -> prepare("INSERT INTO tb10 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindValue(':date', $postedAt, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
        $sql -> execute(); 
      }
      };
    
  ?>
          
    <form action="" method="post">
      <label>【投稿フォーム】</label><br>
      <input type="text" name="name" placeholder="名前" value="<?php if(!empty($_POST['edit']) && !empty($_POST['editpass']) && $editpassword == $editpass){echo $editname;}?>"><br> 
     
      <input type="text" name="comment" placeholder="コメント" value="<?php  if(!empty($_POST['edit']) && !empty($_POST['editpass']) && $editpassword == $editpass){echo $editcomment;}?>"><br>
      
      <input type="text" name="pass" placeholder="パスワード" >
      
      <input hidden="text" name="number" placeholder="投稿番号" value="<?php  if(!empty($_POST['edit']) && !empty($_POST['editpass']) && $editpassword == $editpass){echo $editnumber;}?>"><br>
      <input type="submit" name="submit" value="送信"><br>
      
    </form>

    <form action="" method="post">
    <label>【削除フォーム】</label><br>
      <input type="text" name="dnum" placeholder="削除対象番号"><br>
      <input type="text" name="delpass" placeholder="パスワード" >
      <input type="submit" name="delete" value="削除"><br>
      
    </form>
    
    <form action="" method="post">
    <label>【編集フォーム】</label><br>
      <input type="text" name="edit" placeholder="編集対象番号"><br>
      <input type="text" name="editpass" placeholder="パスワード" >
      <input type="submit"  value="編集"><br>
     
    </form>
<?php

 //table echo
 $sql = 'SELECT * FROM tb10';
 $stmt = $pdo->query($sql);
 $results = $stmt->fetchAll();
 foreach ($results as $row){
     //$rowの中にはテーブルのカラム名が入る
     echo (int)$row['id'].',';
     echo $row['name'].',';
     echo $row['comment'].',';
     echo $row['date'].'<br>';
 echo "<hr>";
 }
?>