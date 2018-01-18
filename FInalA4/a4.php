<!DOCTYPE html>
<html>

<head>
<title>a4.php</title>
<link href="cssPop.css" type="text/css" rel="stylesheet" />

<script>
//function popWind(buttonName){
//	window.open("convertWind.php", buttonName, "height=400, width=300, scrollbars=yes");
//}

function uploadClick(elemId){
	document.getElementById(elemId).click();
    document.getElementById("myFile").addEventListener("change", submitClick);
}

function submitClick(){
    document.getElementById("subFile").click();
}

function toggle_popUp(elemId){
	var e = document.getElementById(elemId);
	if(e.style.display == "block"){
		e.style.display = "none";
	}
	else{
		e.style.display = "block";
	}
}

</script>

<style>
colorUp{
	color: black;
}

big{
    font-size: 23px;
}
bordChange{
    border-style: solid;
}

fieldset{
	display: block;
	margin-left: -18px;
	padding-left: 1.90em;
	padding-right: 1.90em;
	padding-bottom: 1.90em;
	border: 3px solid white;
	border-style: solid;
	border-radius: 12px;
}
</style>

</head>

<body bgcolor=808080>

<?php
	$dir = getcwd()."/files";
	//make sure to take out the bgordo01 since it will ONLY be in /srv/www
	$currFiles = scandir($dir,1);
?>

<div id="conDiv" style="position: fixed; left: 180px; top: 50px;">
	<!-- Moves the Convert button location -->
        <div id="wrapper" style="position:fixed; left: 420px; top:10px;">
        	<button id="Con" onclick="toggle_popUp('conPop');" style="height:50px;width:150px;" >
            	<a href="javascript:void(0)"><b><big>Convert</big></b></a>
            </button>
        </div>
</div>


<div id="conPop" class="popup-position" style="position: fixed; top: 300px; left: 560px">
	<div id="pop_wrapper">
		<div id="pop_cont">
			<h3>Convert</h3>
				<div id="fileList" style="position:fixed; left:575px;">
					<fieldset style="width:460px;">
						<form action = "" method="post">
							<?php
								foreach($currFiles as $fpNames){
									natcasesort($currFiles);
									if(strpos($fpNames, ".html") == false && strlen($fpNames) > 2){
										if(strpos($fpNames, ".info") == false){
					                    	//echo "<input type=\"radio\" name=\"fileName\" value=$fpNames\" >", $fpNames, "<br>";
                       			        	echo "<input type='radio' name='fileName' value=$fpNames>", $fpNames, "<br>";
										}
									}
								}
								unset($fpNames);
							?>
							<button id="submitCon" type="submit" name="submitCon" value="Ok" style="position: fixed; left: 585px; bottom:290px;">Ok</button>
						<!-- </form> -->
						<?php
			                //$currDir = getcwd()."/files/
                    		//$currFile = $currDir.basename($_FILES['myFile']['name']);

      					    if(isset($_POST['submitCon'])){
                             	if(isset($_POST['fileName'])){
                                	$fpValue = "./files/". $_POST['fileName'];
									//echo $fpValue;
                                    exec("./a4 ".$fpValue);
                                }
			                	header('Location: ./a4.php');
                        	}
                		?>
						</form>
					</fieldset>
			</div>
				<div id="cancButt" style="position:fixed; left:670px; bottom:290px;">
        			<button id="CANCEL" onclick="toggle_popUp('conPop');">
                		 <a href="javascript:void(0)">Cancel</a>
        			</button>
				</div>
		</div>
	</div>
</div>

<!-- Uploading Button & functionality as form -->
<div id="upDiv" style="position: fixed; left: 740px; top: 50px;">
	<button id="upButt" style="height:50px;width:150px;" type="button" onclick="uploadClick('myFile');"><b><big><colorUp>Upload</colorUp></b></big></button>
</div>

<form id="upLoading" method="post" action="upClick.php" enctype="multipart/form-data">
	<input id="myFile" name="myFile" type="file" style="display:none;"/>
	<input id="subFile" value="Upload" type="submit" style="display:none;"/>
</form>

<!-- Uploading Button & functionality as form -->

<!-- Moves the .txt list -->
<div id="rawFileDiv" style="position: fixed; left: 435px; top: 100px;">
	<fieldset>
		<?php
			foreach($currFiles as &$fpNames){
            	if((strpos($fpNames, ".html") == false) && (strlen($fpNames) > 2)){
                	if(strpos($fpNames, ".info") == false){
						//if(strpost($fpNames, ".html") == false){
						echo "<a href=\"files/$fpNames\">", $fpNames."<br>", "</a> ";
                                		//}
					}
				}
            }
            unset($fpNames);
		?>
	</fieldset>
</div>

<!-- DB Store button; A4 Stuff below -->

<div id="dbDiv" style="position: fixed; left: 180px; top: 50px;">
    <!-- Moves the Convert button location -->
        <div id="wrapper" style="position:fixed; left: 1060px; top:10px;">
            <button id="dbStore" onclick="toggle_popUp('dBPop');" style="height:50px;width:150px;" >
                <a href="javascript:void(0)"><b><big>DB Store</big></b></a>
            </button>
        </div>
</div>

<div id="dBPop" class="popup-position" style="position: fixed;top:300px;left:560px">
	<div id="pop_dbWrapper">
		<div id="pop_dpStore">
			<h3>Database Store</h>
			<div id="dbFiles" style="position:fixed; left:575px;">
				<fieldset style="width:450px;">
					<form action="" method="post">
						<?php
								foreach($currFiles as $fpNames){
                                    if(strpos($fpNames, ".html") == false && strlen($fpNames) > 2){
                                        if(strpos($fpNames, ".info") == false){
                                            //echo "<input type=\"radio\" name=\"fileName\" value=$fpNames\" >", $fpNames, "<br>";
                                            echo "<input type='radio' name='fileName' value=$fpNames>", $fpNames, "<br>";
										}
                                    }
                                }
                                unset($fpNames);
                            ?>
                            <button id="submitDb" type="submit" name="submitDb" value="Ok" style="position: fixed; left: 585px; bottom:290px;">Ok</button>
                        <?php
                            if(isset($_POST['submitDb'])){
                                if(isset($_POST['fileName'])){
                                    $fpValue = "./files/". $_POST['fileName'];
                                    //echo $fpValue;
                                    exec("./a4 ".$fpValue." 2");
                                	//$deleter = str_replace(".txt", ".txt.html", $fpValue);
									//just delete the .html file from the ./files/ dir
									//unlink($deleter);
								}
                            	header('Location: ./a4.php');
								//look inside db to display in htmldiv ... get rid of the .html files in the folder?
                            }
						?>
					</form>
				</fieldset>
				<div id="cancButtDb" style="position:fixed; left:670px; bottom:290px;">
                    <button id="CANCEL" onclick="toggle_popUp('dBPop');">
                         <a href="javascript:void(0)">Cancel</a>
                    </button>
                </div>
			</div>
		</div>
	</div>
</div>

<div id="htmlDiv" style="position: fixed; left: 760px; top: 100px;">
        <fieldset>
                <!-- just to show the .html files from the ./files/ directory -->
                <?php
					$plainArray = [];
                    foreach($currFiles as &$fpNames){
                        if(strpos($fpNames, ".html") == true){
                            //echo "<a href=\"files/$fpNames\">", $fpNames."<br>", "</a> ";
							$plainArray[] = $fpNames;
                        	//echo $fpNames;
						}
                    }
                    unset($fpNames);
                ?>
                <!-- this php block will show all the files from the database-->
                <?php
					$dbServArray = [];
					$finalArr = [];
                    $dbFiles = shell_exec("./db -php");
                    $explodedFiles = explode(" ", $dbFiles);
                    foreach($explodedFiles as &$dbExploded){
                        //echo $dbExploded;
						//if(strlen($dbExploded) > 8){
						if($dbExploded != NULL){
							//echo "<a href='dbContent.php?file=$dbExploded'".">".$dbExploded.".txt.html"."<br>"."</a>";
							$dbServArray[] = $dbExploded;
						}
					}
					$finalArr = array_merge($plainArray,$dbServArray);
					natcasesort($finalArr);
					foreach($finalArr as &$allFiles){
						//natcasesort($finalArr);
						if(in_array($allFiles, $dbServArray)){
							echo "<a href='dbContent.php?file=$allFiles'".">".$allFiles.".txt.html"."<br>"."</a>";
						}
						else if(in_array($allFiles, $plainArray)){
							echo "<a href=\"files/$allFiles\">", $allFiles."<br>", "</a> ";
						}
                	}
				?>
        </fieldset>
</div>





</body>
</html>
