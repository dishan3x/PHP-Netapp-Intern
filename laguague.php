<?php

/*************************************************************************************  
 *	Author : Dishan Nahitiya                                                         *
 *	Page consist of content of the languaeg preferences accoording to the user.      * 
 *	Users are devided according the language	                                     *
 *                                                                                   *
 ************************************************************************************/


	session_start();
	require_once '../mysql.php';
	
    $language_list_query = "select id,name, LANGU_CORR from master.languages WHERE deleted=0 ORDER BY name ASC";
	$language_list_rs = mysqli_query($connect,$language_list_query);
	
?>



<style>

/*
My style sheet won't work . so im editing styles over here 
*/

.list-group-item {
height : 1 px !important;
padding : 2px 2px ; !imporant ;
}

</style>

<!-- starting pane consist of all the languages -->	
<!-- Display the languagues pane --> 

<div id="dialog"></div>     



<div id = 'selection_display'>

		<div id = 'th' class = 'heading'>Language Preferences</div>
					
	
		<div id = 'mh' class = 'heading'>
			<ul class='nav nav-tabs nav-justified' id = 'tabrow' role='tablist'>
				<li role='presentation' id = 'languageType' class='active'><a href='#' aria-controls='languages' role='tab' data-toggle='tab'>Language</a></li>
			</ul>
		</div>

	<!--	<a href="#" class="btn btn-default btn-circle glyphicon glyphicon-plus"> Add a language<i class="fa fa-user"></i></a> -->
		<button  id ='btn_add' class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add language
		</button>

		<div id = 'add_div' class = 'row'>
			<div class = 'col-lg-12'>
				<br>
				<div id='user_lang' class = 'container-fluid'>
						<input type = 'text' id = 'languageAdd' class = 'form-control' placeholder = 'Enter new language' size = '35'> 
						<input type = 'text' id = 'languageCodeAdd' class = 'form-control' placeholder = 'Enter new language code' size = '3'>
						</br>
						<button id="add_btn_click" class = 'btn btn-default btn-primary'  float='right' >add</button>
						
				</div><br>
			</div>
		</div>
	
	<!-- languuage types -->
		<div id = 'datacols'>
			<div id = 'languageData' >
			
				<?php
				while ($lanData = mysqli_fetch_assoc($language_list_rs)) {
					//echo "<div class='btnlanguagespacing' style ='padding-bottom: 5px; ' >";
							echo "<div class = 'btnLanguageData'><button type = 'button' id = 'languageBtn' class = 'languageBtnClass  list-group-item '  value = '" .  $lanData["id"]  ."'><a href='#'>" . $lanData["name"] . "</a>
							<a href='#'><span class='glyphicon glyphicon-minus btn-default delete_button' value = '".  $lanData["id"] ."'style='float:right'></span></a></div>";
					//echo "</div>";	
				}
				?>
			</div>
		</div>
		
</div>
	

	
	
	
	
<!-- on button click, show this display. -->
<!-- grab information from database and populate in div -->	
<div id = 'information_display'>
		
		<div id = 'th' class = 'heading'>Language Preferences</div>
		
		<div id = 'mh' class = 'heading'>
			<ul class='nav nav-tabs nav-justified' id = 'tabrow' role='tablist'>
				<li role='presentation' id = 'languageType' class='active'><a href='#' aria-controls='languages' role='tab' data-toggle='tab'>People</a></li>
			</ul>
		</div>
			
		<div class = 'col-lg-12'><br>
			<div id='user_lang' class = 'input-group'>
				<input type = 'text' id = 'profileSearch' class = 'form-control' placeholder = 'Enter search here...'>
				<span class = 'input-group-btn'>
				<button class = 'btn btn-default' type = 'submit'>Search</button>
				</span>
			</div><br>
		</div>

		<!-- Display div of the users of the language -->
		<div id = 'disp_info_div'>
			<div class = 'heading'>Loading...</div>	
		</div>
	
		<!-- close button -->
		<ul class='nav nav-tabs nav-justified' id = 'close_disp' role='tablist'>
			<li role='presentation' id = 'exittab' ><a href='#' aria-controls='skills' role='tab' data-toggle='tab'>Close Information Display</a></li>
		</ul>
	
</div>


	


	
<script>

		//height
var mheight = 0;
		
$(document).ready(function() {
		
		
		// on load, find height for the display
		var mheight = $("#menu_pane").height() - $("#menu_buffer").height() - $("#menu_title").height() - $("#th").height() - $("#mh").height() - $("#searchdiv").height() - 20;
	
		// on load, make $("#information_display") and add_div disappear
		$("#information_display").hide();
		$("#add_div").hide(); 
		
		// on load, make sure #datacols height is correct
		$("#datacols").css("height", mheight);
		
		$("#disp_info_div").css("height", mheight + $("#searchdiv").height() - $("#exittab").height() - 20);
		//$("#close_disp").css("height", (mheight));

	
		// creating a dialog box to  let the use to confirm
		$("#dialog").dialog({
        modal: true,
        bgiframe: true,
        width: 500,
        height: 200,
        autoOpen: false	 });
		

		// When click on the exit
		$("#exittab").click(function(e) {
			$("#disp_info_div").empty();
		});
		
		//add tab toggle
		$("#btn_add").click(function(e){
			$("#add_div").toggle();
		});
		
		
		
		
		
		
		//show the language users
		// when selected the languague name 
		$("#languageData").on('click','.languageBtnClass',function(e){
			var funcname = '';
			$("#exittab").removeClass("active");
			console.log($(this).text());
			button_id = $(this).attr('value'); 
			console.log(button_id + " value");
			// load #information_display
			$("#selection_display").toggle();
			$("#information_display").toggle();
			// add an exit on information_display
			funcname = "show_language_users";	
			console.log("funcname: " + funcname + " value: " + button_id);
		 	$("#disp_info_div").load("search_users_by_language.php?funcname=" +encodeURIComponent(funcname) + "&val=" +encodeURIComponent(button_id) + "&val2=" +encodeURIComponent(button_id) + "&txt=" + encodeURIComponent($(this).text()), function(response, status, xhr) {	
				if(status == "error") {
					var msg = "Error: ";
					console.log(msg + xhr.status + " " + xhr.statusText);
				}
			});		
		});
	
		
		
			
		// profile search after loading the profile according to selected language
		$("#profileSearch").change(function(e) {
			ProfileSearch();
		});
		// on keypress
		$("#profileSearch").keyup(function (e) {
			//setInterval(function(){search4f();},2000);	
			ProfileSearch();
		}); 
		
		
		function ProfileSearch()
		{
			var searchtext = $("#profileSearch").val().toLowerCase();
			
				$(".user_from_language").each(function(i) {
					if($(this).text().toLowerCase().match(new RegExp(searchtext))) {
						$(this).show();
					}
	
					else {
					$(this).hide();
					}
			});	
		}
		
		
		
		//button press on the user tabs
		$("#disp_info_div").on('click', '.user_from_language', function(e){
			
				var funcname = '';
				$("#exittab").removeClass("active");
				console.log($(this).text());
				button_id = $(this).attr('value');
				console.log(button_id + " value");
				funcname = "show_language_users";	
				console.log("funcname: " + funcname + " value: " + button_id);	 
				var username  = $(this).data("username");
				console.log("usernamevalue"+ username);	
				// change
				$("#disp_info_div").load(open_user_profile(username,'languages',{menu: 'manage', submenu: 'languages'}));	
		});
		
		
		
			
		$("#disp_info_div").on('click', '.no_user_from_language', function(e){
			$("#information_display").toggle();
			$("#selection_display").toggle();
				
		});	
		
		$(".glyphicon-minus").hover(function(){
        $(this).css("background-color", "#DFFFFF");
        }, function(){
        $(this).css("background-color", "#fff");
		});
			
						
			
		
		// add button 
		// when  you want to add a language into the system
		// both language and language code fields neeed to be filled inorder to go through
		$("#add_btn_click").click(function(){
			
			if($("#languageAdd").val().length> 0 && $("#languageCodeAdd").val().length> 0  ){
				if (confirm("Are you sure you want to do this action?")){	
					var	funcname = "Add_language";
					var Addlang  = $("#languageAdd").val();
					var AddlangCode = $("#languageCodeAdd").val().toUpperCase();	
					$("#disp_info_div").load("search_users_by_language.php?funcname=" +encodeURIComponent(funcname) + "&val=" +encodeURIComponent(Addlang) + "&val2=" +encodeURIComponent(AddlangCode) +"&txt=" + encodeURIComponent($(this).text()), function(response, status, xhr) {	
						if(status == "error") {
							var msg = "Error: ";
							console.log(msg + xhr.status + " " + xhr.statusText);
						}
						$("#add_div").hide();
						$("#languageData").load("../API/languages.php"); // reload the modified content	(add contennt)	
						alert("language successfully added");	
					});	
					
				} 
			}
			else if ($("#languageAdd").val().length > 0 && $("#languageCodeAdd").val().length == 0  ){
				alert('Please enter a language Code');
			}
			else if ($("#languageAdd").val().length == 0 && $("#languageCodeAdd").val().length> 0  ){
				alert('Please enter a language');
			}		
		});
		
		

		// toggle the panes when press close display
		$("#exittab").click(function(e){
			$("#information_display").toggle();
			$("#selection_display").toggle();
		});
	
		
		
		// Delete a language from the data base
		$("#languageData").on('click','.delete_button',function(e){

			console.log("remove this language");
			if (confirm("Are you sure you want delete this language?")){
				funcname = "Delete_language";
				deletelang = $(this).attr('value');
				//deletelang  = $("#languageBtn").val();
				$("#disp_info_div").load("search_users_by_language.php?funcname=" +encodeURIComponent(funcname) + "&val=" +encodeURIComponent(deletelang) + "&val2=" +encodeURIComponent(deletelang) + "&txt=" + encodeURIComponent($(this).text()), function(response, status, xhr) {
					if(status == "error") {
						var msg = "Error: ";
						console.log(msg + xhr.status + " " + xhr.statusText);
					}
					else{
						console.log("deleted");
						$("#languageData").load("../API/languages.php"); // reload the modified content
						alert("language successfully removed");	
					}
				});	
				
			}	
			//$("#languageData").load("API/languages.php");
			$("#selection_display").toggle();
			$("#information_display").toggle();
		});
	

	
		
});// end of Document.Ready	
		
	
	
	



		
</script>