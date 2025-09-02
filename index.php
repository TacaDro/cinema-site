<?php
require __DIR__.'/db.php';
require __DIR__.'/csrf.php';
$config = require __DIR__.'/config.php';

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($base==='.'||$base==='/') $base='';

function h($s){return htmlspecialchars((string)$s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function slug($s){$s=iconv('UTF-8','ASCII//TRANSLIT',$s);$s=preg_replace('~[^a-z0-9]+~i','-',$s);return trim(strtolower($s),'-')?:'item';}
function genre_slug($g){ return strtolower(str_replace(' ','-',trim($g))); }
function url_movie($id,$title){global $base;return "$base/film/$id-".slug($title);} 

function get_genres(PDO $pdo, int $limit = 20): array {
  $stmt = $pdo->query("SELECT DISTINCT genre FROM movies WHERE genre<>'' ORDER BY genre ASC");
  $list = [];
  foreach ($stmt as $row) {
    $name = trim($row['genre']);
    if ($name==='') continue;
    // >>> ВОТ ЭТА СТРОКА ДОЛЖНА БЫТЬ <<<
    $list[] = ['name'=>$name, 'slug'=>strtolower(str_replace(' ','-', $name))];
  }
  return array_slice($list, 0, $limit);
}

function render($view,$data=[]){
  extract($data,EXTR_SKIP);
  global $pdo; $genres = get_genres($pdo);
  include __DIR__.'/views/_layout.php';
}
function require_admin(){if(empty($_SESSION['is_admin'])){global $base;header('Location: '.($base?:'').'/admin/login');exit;}}

$uri=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$path=$base&&str_starts_with($uri,$base)?substr($uri,strlen($base)):$uri;
$path='/'.ltrim($path,'/');

// Главная
if($path==='/'||$path==='/index.php'){
  $q=trim($_GET['q']??''); $sql='SELECT id,title,`year`,genre,poster_url FROM movies';
  $p=[]; if($q!==''){ $sql.=' WHERE title LIKE :q'; $p[':q']="%$q%"; }
  $sql.=' ORDER BY id DESC LIMIT 200';
  $st=$pdo->prepare($sql);$st->execute($p);$movies=$st->fetchAll();
  return render('home',compact('movies','q','base'));
}

// Фильм
if(preg_match('~^/film/(\d+)~',$path,$m)){
  $id=(int)$m[1];$st=$pdo->prepare('SELECT * FROM movies WHERE id=:id');$st->execute([':id'=>$id]);$movie=$st->fetch();
  if(!$movie){http_response_code(404);return render('404',compact('base'));}
  return render('movie',compact('movie','base'));
}

// Жанр
if(preg_match('~^/genre/([a-z0-9-]+)$~',$path,$m)){
  $slug=$m[1];
  $st=$pdo->prepare('SELECT id,title,year,genre,poster_url FROM movies WHERE LOWER(REPLACE(genre," ","-")) LIKE :g ORDER BY id DESC');
  $st->execute([':g'=>strtolower($slug).'%']);
  $movies=$st->fetchAll();
  $genre_name=str_replace('-',' ',$slug);
  return render('genre',compact('movies','genre_name','base'));
}

if($path==='/poisk'){$q=trim($_GET['q']??'');header('Location: '.($base?:'').'/?q='.urlencode($q));exit;}

// Админка
if($path==='/admin/login'){
  if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!csrf_check($_POST['csrf']??null))die('CSRF');
    if(hash_equals($config['admin']['password'],$_POST['password']??'')){
      $_SESSION['is_admin']=true;header('Location: '.($base?:'').'/admin');exit;}
    $error='Неверный пароль';
  }
  $view='admin/login';return render($view,compact('error','base'));
}
if($path==='/admin/logout'){unset($_SESSION['is_admin']);header('Location: '.($base?:''));exit;}
if($path==='/admin'){require_admin();$st=$pdo->query('SELECT * FROM movies ORDER BY id DESC');$movies=$st->fetchAll();$count=count($movies);$view='admin/dashboard';return render($view,compact('movies','count','base'));}
if($path==='/admin/movie/new'){require_admin();$action=($base?:'').'/admin/movie/create';$view='admin/form';return render($view,compact('action','base'));}
if($path==='/admin/movie/create'&&$_SERVER['REQUEST_METHOD']==='POST'){
  require_admin();if(!csrf_check($_POST['csrf']??null))die('CSRF');
  $st=$pdo->prepare('INSERT INTO movies(title,year,genre,description,poster_url) VALUES(:t,:y,:g,:d,:p)');
  $st->execute([':t'=>$_POST['title'],':y'=>(int)$_POST['year'],':g'=>$_POST['genre'],':d'=>$_POST['description'],':p'=>$_POST['poster_url']?:null]);
  header('Location: '.($base?:'').'/admin');exit;}
if(preg_match('~^/admin/movie/(\d+)/edit$~',$path,$m)){require_admin();$id=(int)$m[1];$st=$pdo->prepare('SELECT * FROM movies WHERE id=:id');$st->execute([':id'=>$id]);$movie=$st->fetch();$action=($base?:'')."/admin/movie/$id/update";$view='admin/form';return render($view,compact('movie','action','base'));}
if(preg_match('~^/admin/movie/(\d+)/update$~',$path,$m)&&$_SERVER['REQUEST_METHOD']==='POST'){
  require_admin();if(!csrf_check($_POST['csrf']??null))die('CSRF');$id=(int)$m[1];
  $st=$pdo->prepare('UPDATE movies SET title=:t,year=:y,genre=:g,description=:d,poster_url=:p WHERE id=:id');
  $st->execute([':t'=>$_POST['title'],':y'=>(int)$_POST['year'],':g'=>$_POST['genre'],':d'=>$_POST['description'],':p'=>$_POST['poster_url']?:null,':id'=>$id]);
  header('Location: '.($base?:'').'/admin');exit;}
if(preg_match('~^/admin/movie/(\d+)/delete$~',$path,$m)&&$_SERVER['REQUEST_METHOD']==='POST'){
  require_admin();if(!csrf_check($_POST['csrf']??null))die('CSRF');$id=(int)$m[1];$st=$pdo->prepare('DELETE FROM movies WHERE id=:id');$st->execute([':id'=>$id]);header('Location: '.($base?:'').'/admin');exit;}

http_response_code(404);render('404',compact('base'));
