
<?php
		require_once("db.php");
		error_reporting(0);
		if(! $dbconn ) {
			die('Could not connect: ' . mysqli_error());
		}
		$start=0;
		$limit=6;
		/*pagination*/
		$additionalStr = '';
		if($_GET['Language']){
			$additionalStr .= "&Language=".$_GET['Language'];
		}if($_GET['Genre']){
			$additionalStr .= "&Genre=".$_GET['Genre'];
		}if($_GET['Sort']){
			$additionalStr .= "&Sort=".$_GET['Sort'];
		}
		if(isset($_GET['Page']))
		{
			$Page=$_GET['Page'];
			$start=($Page-1)*$limit;
		}
		if(empty($_GET['Language']) && empty($_GET['Genre'])){
			$rows=mysqli_num_rows(mysqli_query($dbconn,"select * from tbl_movies"));
		}else{
			$valId = (!empty($_GET['Language']))?$_GET['Language']:$_GET['Genre'];
			$rows=mysqli_num_rows(mysqli_query($dbconn,"select DISTINCT(movie_id) from `tbl_movie_relation` WHERE taxonomy_id='".mysqli_real_escape_string($dbconn,$valId)."'"));
			
		}	
		$total=ceil($rows/$limit);
		$pagStr = '';
		if($Page>1)
		{
			$pagStrP .= "<a href='?Page=".($Page-1).$additionalStr."' class='button'> < </a>";
		}
		if($Page!=$total || !($_GET["Page"]))
		{
				
			if(!($_GET["Page"])){
				if($rows > 10)	
					$pagStrN .= "<a href='?Page=".($Page+2).$additionalStr."' class='button'> > </a>";
			}else{
				$pagStrN .=  "<a href='?Page=".($Page+1).$additionalStr."' class='button'> > </a>";
			}	
		}
		$pageNum .= "<ul class='page'>";
		for($i=1;$i<=$total;$i++)
		{
			if($i==$Page) { $pageNum .=  "<li class='current'>".$i."</li>"; }

			else { $pageNum .= "<li><a href='?Page=".$i.$additionalStr."'>".$i."</a></li>"; }
		}
		$pageNum .= "</ul>";
		
		$firstPage = "<a href='?Page=1".$additionalStr."' class='button'> << </a>";
		$LastPage = "<a href='?Page=".($total).$additionalStr."' class='button'> >> </a>";
		/*Pagination ends*/
		
		$filterLangSql = "SELECT id,value  FROM `tbl_movie_categories` WHERE `type` = 'Language'";
		$filterLangRes=mysqli_query($dbconn,$filterLangSql);
		$Language = "<option value='0'>Please select the Language</option>";
		while($Langrow = mysqli_fetch_array($filterLangRes, MYSQLI_ASSOC))
		{	
			if($_GET['Language'] == $Langrow['id']){
				$selectedLang = 'selected';
			}else{
				$selectedLang = '';
			}	
				$Language .= "<option value='{$Langrow['id']}' ".$selectedLang.">{$Langrow['value']}</option>";
		}
		
		$filterGenreSql = "SELECT id,value  FROM `tbl_movie_categories` WHERE `type` = 'Genre'";
		$filterGenreRes=mysqli_query($dbconn,$filterGenreSql);
		$Genre = "<option value='0'>Please select the Genre</option>";
		while($Genrerow = mysqli_fetch_array($filterGenreRes, MYSQLI_ASSOC))
		{	
			if($_GET['Genre'] == $Genrerow['id']){
				$selectedGenre = 'selected';
			}else{
				$selectedGenre = '';
			}
			$Genre .= "<option value='{$Genrerow['id']}' ".$selectedGenre.">{$Genrerow['value']}</option>";
		}
		
		$sortArr = array("Please select the option to Sort","Length","Release Date");
		for($i=0;$i<count($sortArr);$i++){
			if($_GET['Sort'] == $i){
				$sortSelected = "selected";
			}else{
				$sortSelected = "";
			}
			$sortOption .= "<option value='".$i."' ".$sortSelected.">".$sortArr[$i]."</option>";
		}
		
		
		$where = $additionalSql = $groupBy = $orderBy = '';	
		if(!empty($_GET['Language']) && empty($_GET['Genre'])){
			$where = " WHERE lang_cat.type='Language' AND lang_cat.id = '".mysqli_real_escape_string($dbconn,$_GET['Language'])."' ";
			$additionalSql  = "INNER JOIN tbl_movie_relation mrLang ON mrLang.movie_id = tm.id ";
			$additionalSql .= "INNER JOIN tbl_movie_categories lang_cat ON (lang_cat.id = mrLang.taxonomy_id) ";
		}
		if(empty($_GET['Language']) && !empty($_GET['Genre'])){
			$where = " WHERE genre_cat.type='Genre' AND genre_cat.id = '".mysqli_real_escape_string($dbconn,$_GET['Genre'])."' ";
			$additionalSql  = "INNER JOIN tbl_movie_relation mrGenre ON mrGenre.movie_id = tm.id ";
			$additionalSql .= "INNER JOIN tbl_movie_categories genre_cat ON (genre_cat.id = mrGenre.taxonomy_id) ";
		}
		if(!empty($_GET['Sort'])){
			if($_GET['Sort'] == 1){
				$orderBy = " ORDER BY length ASC";
			}else{
				$orderBy = " ORDER BY release_date ASC";
			}
		}

		$groupBy = " GROUP BY tm.id ";
		$query = "SELECT tm.* ,group_concat(DISTINCT(langCat.value)) AS Language, group_concat(DISTINCT(genreCat.value)) AS Genre FROM tbl_movies tm LEFT JOIN tbl_movie_relation tmr ON tmr.movie_id = tm.id LEFT JOIN tbl_movie_categories langCat ON (langCat.id = tmr.taxonomy_id AND langCat.type = 'Language') LEFT JOIN tbl_movie_categories genreCat ON (genreCat.id = tmr.taxonomy_id AND genreCat.type = 'Genre') LEFT JOIN tbl_movie_relation mr ON mr.movie_id = tm.id ".$additionalSql.$where.$groupBy.$orderBy." LIMIT ".$start.",".$limit;	
		
		$qresult=mysqli_query($dbconn,$query);
		$tableData = '';
		
		while($row = mysqli_fetch_array($qresult, MYSQLI_ASSOC))
		{
			if(!empty($row['featured_image'])){
				$images = "<img src='images/".$row['featured_image']."' width='100px'/>";
			}else{
				$images="";
			}	
			$tableData .="<tr>
							<td class='text-left'>{$row['title']}</td>
							<td class='text-left'>".$images."</td>
							<td class='text-left'>{$row['Language']}</td>
							<td class='text-left'>{$row['length']}</td>
							<td class='text-left'>{$row['Genre']}</td>
							<td class='text-left'>{$row['release_date']}</td>
						</tr>";
		}				
		 
			
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<meta charset="utf-8">
		<title>Movies</title>
        <link rel="stylesheet" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script>
			$(document).ready(function(e){
				$("select[name=LanguageFilter]").change(function(e){
					var str = "?Language="+$("select[name=LanguageFilter]").val();
					if($("select[name=Sort]").val() > 0){
						str += "&Sort="+$("select[name=Sort]").val(); 
					}
					window.location.href = "index.php"+str;

				});	
				$("select[name=GenreFilter]").change(function(e){
					var str = "?Genre="+$("select[name=GenreFilter]").val();
					if($("select[name=Sort]").val() > 0){
						str += "&Sort="+$("select[name=Sort]").val(); 
					}
					window.location.href = "index.php"+str;

				});
				$("select[name=Sort]").change(function(e){
					var str = "?Sort="+$("select[name=Sort]").val();
					if($("select[name=GenreFilter]").val() > 0){
						str += "&Genre="+$("select[name=GenreFilter]").val(); 
					}if($("select[name=LanguageFilter]").val() > 0){
						str += "&Language="+$("select[name=LanguageFilter]").val(); 
					}
					window.location.href = "index.php"+str;

				});
			});
		</script>
	</head>
	<body  style="background-color: black" >
		<header class="header">
        <a href="#default" class="logo" style="color:#FFC107" >ToMovies.in</a>
        <div class="header-right">
        <a class="active" href="#home">Home</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
        </div>
        </header>
		<div class="selectContainer">
			<div class="select-style">
				<select name="LanguageFilter">
					<?= $Language ?>
				</select>
			</div>	
			
			<div class="select-style">
				<select name="GenreFilter">
					<?= $Genre ?>
				</select>
			</div>	
			
			<div class="select-style">	
				<select name="Sort">
					<?= $sortOption ?>
				</select>
			</div>
		</div>	
		<div class="spacer"></div>
		
		<table class="table-fill">
			<thead>
				<tr>
					<th class="text-left">Movie Name</th>
					<th class="text-left">Movie Image</th>
					<th class="text-left">Language</th>
					<th class="text-left">Length</th>
					<th class="text-left">Genre</th>
					<th class="text-left">Release date</th>
				</tr>
			</thead>
			<tbody class="table-hover">
				<?= $tableData ?>
			</tbody>
		</table>
		<div class="paginationContainer">
			<?= $firstPage ?><?= $pagStrP ?> <?= $pageNum ?> <?= $pagStrN ?> <?= $LastPage ?>
		</div>	
		 <footer class="footer">
        <p>copyright@ToMovies.in</p>
        <div class="footer-right">
        <p>design by:Saurabh Vernekar</p>
        </div>  
        </footer>
	</body>
</html>