<?php
// LITTLE BIT OF CODE WHICH I WORK IN PHP IN NETAPP. 
	session_start();
	require_once 'mysql.php';	
/*
	$skill_array = array();
	$queue_array = array();
	$match_array = array();		

	// currently restructuring php files so kind of unorganized atm.	
	// not sure if it's common practice to exercise oop stuff like classes, but
	// I'm going to start making classes in php unless told otherwise
	// rewriting functions to switch from repeated sql queries to just running them once	
*/
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		// POST
	}
	else {
		// GET
		$funcname = $_GET['funcname'];	
		if($funcname == 'disp_match')
		{
		}
	}

	
	//q2c table
	$q2c_list_query = "select id, queue_id, cat_code_combo_id from master.queue_to_cat_codes_mappings";
	$q2c_list_rs = mysqli_query($connect, $q2c_list_query);
	

	// skill table
	$ccc_list_query = "select id,cat1_desc, cat2_desc from master.cat_code_combos";
	$ccc_list_rs = mysqli_query($connect,$ccc_list_query);

	// queue table
	$queue_list_query = "select id, name, sap_id, region, level from master.queues";
	$queue_list_rs = mysqli_query($connect,$queue_list_query);

	
	
	// selection display
	echo "<div id = 'selection_display'>";
		echo "<div id = 'th' class = 'heading'>Skill to Queue Mappings</div>";
					
			// ends col div
			//echo "</div>";
		// ends row div
		//echo "</div>";

		echo "<div id = 'mh' class = 'heading'>";
		echo "<ul class='nav nav-tabs nav-justified' id = 'tabrow' role='tablist'>";
		echo "<li role='presentation' id = 'skilltab' class='active'><a href='#' aria-controls='skills' role='tab' data-toggle='tab'>By Skill</a></li>";
		echo "<li role='presentation' id = 'queuetab'><a href='#' aria-controls='skills' role='tab' data-toggle='tab'>By Queue</a></li>";
		echo "</ul>";
		echo "</div>";

		echo "<div id = 'searchdiv' class = 'row'>";
			echo "<div class = 'col-lg-12'>";	
				echo "<br>";
	//			echo "<form class = 'ccc-search'>";
				echo "<div class = 'input-group'>";
				echo "<input type = 'text' id = 'skillsearch' class = 'form-control' placeholder = 'Enter search here...'>";
				echo "<span class = 'input-group-btn'>";
				echo "<button class = 'btn btn-default' type = 'submit'>Search</button>";
				echo "</span>";
				// input group
				echo "</div><br>";
			//col-lg-12
			echo "</div>";
		echo "</div>";
		echo "<div id = 'datacols'>";
			echo "<div id = 'skilldata'>";
				while ($ccc = mysqli_fetch_assoc($ccc_list_rs)) {
					$skill_array[$ccc["id"]]['n1'] = $ccc["cat1_desc"];
					$skill_array[$ccc["id"]]['n2'] = $ccc["cat2_desc"];

					echo "<div class = 'btnskillspacing'><button type = 'button' id = 'skillbtn' class = 'btn btn-secondary btn-sm skillbtn' value = '" . $ccc["id"] ."'><a href='#'>" . $ccc["cat1_desc"] . " - " . $ccc["cat2_desc"] . "</a></button></div>";


				}
			echo "</div>";

			echo "<div id = 'queuedata'>";
				while ($qlist = mysqli_fetch_assoc($queue_list_rs)) {

					$queue_array[$qlist["id"]]['n1'] = $qlist["name"];
					$queue_array[$qlist["id"]]['n2'] = $qlist["region"];
					$queue_array[$qlist["id"]]['sap_id'] = $qlist["sap_id"];
					$queue_array[$qlist["id"]]['level'] = $qlist["level"]; 



					echo "<div class = 'btnqueuespacing'><button type = 'button' id = 'queuebtn' class = 'btn btn-secondary btn-sm queuebtn' value = '" . $qlist["id"] ."'><a href='#'>" . $qlist["name"] . " - " . $qlist["region"] . " - " . $qlist["level"] ."</a></button></div>";

				}
			echo "</div>";	


			echo "<div id = 'q2cdata'>";
				while($q2c=mysqli_fetch_assoc($q2c_list_rs)) {
/*					$q2c_array[$q2c["id"]]['queue_id'] = $q2c["queue_id"];
					$q2c_array[$q2c["id"]]['ccc_id'] = $q2c["cat_code_combo_id"]; */
					echo "<div class = 'btnq2c' id = '" . $q2c['queue_id'] . "' value = '" . $q2c['cat_code_combo_id'] . "'></div>";
				}	
			echo "</div>";		

		echo "</div>";

	// ends selection_display
	echo "</div>";
	echo "<div id = 'information_display'>";
		// on button click, show this display.
		// grab information from db, do a .load() onto this div
			
		echo "<ul class='nav nav-tabs nav-justified' id = 'editmapping' role='tablist'>";
		echo "<li role='presentation' id = 'emappingtab' ><a href='#' aria-controls='skills' role='tab' data-toggle='tab'>Enter Mapping</a></li>";
		echo "<li role='presentation' id = 'dmappingtab' ><a href='#' aria-controls='skills' role='tab' data-toggle='tab'>Delete Mapping</a></li>";
		echo "</ul>";
		
		echo "<ul class='nav nav-tabs nav-justified' id = 'deletemapping' role='tablist'>";

		echo "</ul>";
		echo "<ul class='nav nav-tabs nav-justified' id = 'entermapping' role='tablist'>";

		echo "</ul>";

		echo "<div id = 'info_heading'>";

		echo "</div>";

		echo "<div id = 'disp_info_div'>";


		echo "</div>";
	
		echo "<ul class='nav nav-tabs nav-justified' id = 'close_disp' role='tablist'>";
		echo "<li role='presentation' id = 'exittab' ><a href='#' aria-controls='skills' role='tab' data-toggle='tab'>Close Information Display</a></li>";
		echo "</ul>";
	// ends information_display
	echo "</div>";
	// $selected_queue = $_REQUEST["queue_select"];
	// $selected_ccc = $_REQUEST["ccc_select"];		
	$simple_array = array("1","2","3");

?>

<script>
		var js_disp_array = [];
		var mheight = 0;
		$(document).ready(function() {
		var activeDiv = 0;	
		
		// on load, find height for the display
		var mheight = $("#menu_pane").height() - $("#menu_buffer").height() - $("#menu_title").height() - $("#th").height() - $("#mh").height() - $("#searchdiv").height() - 20;
	
		// on load, make $("#queuedata") disappear
		$("#queuedata").hide();
		// not needed, but hide #q2cdata
		$("#q2cdata").hide();	
		// on load, make $("#information_display") disappear
		$("#information_display").hide();

		// on load, make sure #datacols height is correct
		$("#datacols").css("height", mheight);
		
		$("#disp_info_div").css("height", mheight + $("#searchdiv").height()-20);
		//$("#close_disp").css("height", (mheight));
	
		$("#skillsearch").focus();
	
		$("#exittab").click(function(e) {
			$("#disp_info_div").empty();
			$("#info_heading").empty();
			$("#emappingtab").removeClass("active");
			$("#dmappingtab").removeClass("active");
			$("#emappingform").hide();
		});

		$("#emappingtab").click(function(e) {
			$("#emappingformqid").remove();
			$("#emappingformcccid").remove();
			$("#dmappingformqid").remove();
			$("#dmappingformcccid").remove();
			$("#IDinfo").remove();
			
			var htmlobj = $("#disp_info_div").html();
			$("#disp_info_div").empty();	

			if(activeDiv == 0) 
			{
				$("#disp_info_div").append("<div id = 'emappingformqid' class = 'form-group'><label for='queueid'>Queue ID</label><input type = number class = 'form-control' id = 'queueidinput' placeholder='Queue ID'></div>");
			}
			else {
			$("#disp_info_div").append("<div id = 'emappingformcccid' class = 'form-group'><label for='queueid'>CCC ID</label><input type = number class = 'form-control' id = 'cccidinput' placeholder='CCC ID'></div>");
			}

			$("#disp_info_div").append("<div id = 'IDinfo'>To find the IDs of the relevant CCC/Queue, see the info below.</div>");

			$("#disp_info_div").append("<div id = 'underinfo'>");
			$("#disp_info_div").append("</div>");

			$("#underinfo").append(htmlobj);
		});

		$("#dmappingtab").click(function(e) {
			$("#emappingformqid").remove();
			$("#emappingformcccid").remove();
			$("#dmappingformqid").remove();
			$("#dmappingformcccid").remove();
			$("#IDinfo").remove();

			var htmlobj = $("#disp_info_div").html();
			$("#disp_info_div").empty();	

			if(activeDiv == 0) {
				$("#disp_info_div").append("<div id = 'dmappingformqid' class = 'form-group'><label for='queueid'>Queue ID</label><input type = number class = 'form-control' id = 'queueidinput' placeholder='Queue ID'></div>");
			}
			else {
				$("#disp_info_div").append("<div id = 'dmappingformcccid' class = 'form-group'><label for='queueid'>CCC ID</label><input type = number class = 'form-control' id = 'cccidinput' placeholder='CCC ID'></div>");
			}

			$("#disp_info_div").append("<div id = 'IDinfo'>To find the IDs of the relevant CCC/Queue, see the info below.</div>");

			$("#disp_info_div").append("<div id = 'underinfo'>");
			$("#disp_info_div").append("</div>");
			
			$("#underinfo").append(htmlobj);
		});



		// get clicked button's values
		$(".btn.btn-secondary.btn-sm").click(function(e)
		{
			// Used to store the matching values in the q2c to the clicked button's value
			var matching_id = [];
			// Don't really need this, but have it anyway. Just stores the names of matches.
			var matching_names = [];
			
			$("#exittab").removeClass("active");
			
		
			// grabs the queue or skill ID	
			button_val = $(this).attr('value');
			console.log("-------------");
			console.log(button_val + " value");
			
			// load #information_display
 			
			$("#selection_display").toggle();
			$("#information_display").toggle();

			// if activeDiv 0, then skill
			// elif activeDiv 1, then queue
				
			$("#info_heading").append($(this).text());
			// can break this up in the future, by class specifically like
			// (".btn.btn-secondary.btn-sm.queuebtn").click(function(e)
			if(activeDiv == 0) {
				// load the skill array
				// doesn't seem to work for whatever reason
				// will implement the array after I get it working with the divs
				js_disp_array = <?php echo json_encode($skill_array);?>;
				$("#disp_info_div").append("<div id = 'info_heading'>Matching Queue IDs</div>");
				$(".btnq2c").each(function() {
					if($(this).attr('value') == button_val) {
						$("#disp_info_div").append($(this).attr('id') + "<br>");
						matching_id.push($(this).attr('id'));
						console.log("MID Length: " + matching_id.length);
					}
				});
				$("#disp_info_div").append("<div id = 'info_heading'>Matching Queue Names</div>");
				for(var j = 0; j<matching_id.length; j++)
				{
					$(".btn.btn-secondary.btn-sm.queuebtn").each(function() {
						console.log("ID: " + $(this).attr('value'));
						if($(this).attr('value') == matching_id[j]) {
							matching_names.push($(this).text());
							$("#disp_info_div").append("<div>" + $(this).text() + "</div>");
							console.log("MNAME Length: " + matching_names.length);
						}
					});
				}
			}
			else {
				// load the queue array
				js_disp_array = <?php echo json_encode($queue_array);?>;
				$("#disp_info_div").append("<div id = 'info_heading'>Matching CCC IDs</div>");
				$(".btnq2c").each(function(index, value){
//					console.log("btnq2c id: " + $(this).attr("id"));
					console.log($(this).attr('value'));
					if($(this).attr('id') == button_val) {
						$("#disp_info_div").append($(this).attr('value') + "<br>");
						matching_id.push($(this).attr('value'));
						console.log("MID Length: " + matching_id.length);
					}
				});

					
				console.log("The following are twodim array outputs");
				console.log("Length: " + js_disp_array.length);
/*				for(var l = 0; l<js_disp_array.length; l++)
				{
					for(var m = 0; m<js_disp_array[0].length; m++)
					{
						console.log(js_disp_array[l][m]);

					}

				}
*/
				$("#disp_info_div").append("<div id = 'info_heading'>Matching CCC Names</div>");
				for(var k = 0; k<matching_id.length; k++) {
					$(".btn.btn-secondary.btn-sm.skillbtn").each(function() {
						if($(this).attr('value') == matching_id[k]) {
							matching_names.push($(this).text());
							$("#disp_info_div").append("<div>" + $(this).text() + "</div>");
						}
						
					});
				}
				
			//console.log("<?php //print_r($skill_array);?>");
			var simp_array = <?php echo json_encode($simple_array)?>;
			$("#disp_info_div").append("Is anything coming out" + simp_array);
			}	
			
			
			console.log("Num of mids :" + matching_id.length);
			console.log("Num of mnames:" + matching_names.length);
		 	/* $("#disp_info_div").load("edit_queue.php?funcname=" +encodeURIComponent(funcname) + "&val=" +encodeURIComponent(button_id) + "&txt=" + encodeURIComponent($(this).text()), function(response, status, xhr) {
				if(status == "error") {
					var msg = "Error: ";
					console.log(msg + xhr.status + " " + xhr.statusText);
				}
			}); */	
			
			//$("#pdr").load("edit_queue.php?qid="+encodeURIComponent(queue_id));
			
			

		});





		
		$("#exittab").click(function(e)
		{
			$("#information_display").toggle();
			$("#selection_display").toggle();
		});
		
		// on #skillsearch change
		$("#skillsearch").change(function(e) {
			search4f();
		});

		// on keypress
		$("#skillsearch").keyup(function (e) {
			//setInterval(function(){search4f();},2000);	
			search4f();
		}); 

		// search func
		function search4f()
		{
			console.log("search changed");
			var searchtext = $("#skillsearch").val().toLowerCase();
			console.log(searchtext);
			if(activeDiv == 0) {
				$(".btnskillspacing").each(function(i) {
					if($(this).text().toLowerCase().match(new RegExp(searchtext))){
						$(this).show();
					}
					else {
					$(this).hide();
					}
			});
			}
			else {
				$(".btnqueuespacing").each(function(i) {
					if($(this).text().toLowerCase().match(new RegExp(searchtext))) 					{
						$(this).show();
					}
					else {
					$(this).hide();
					}
				});
			}
		}

		$('#skilltab').click(function(e) {
			console.log("Skill tab clicked");
			if(activeDiv == 1)
			{ 
				activeDiv = 0;
				$("#skilldata").toggle();
				$("#queuedata").toggle();
			}
			else {}
		});

		$('#queuetab').click(function(e) {
			console.log("Queue tab clicked");
			if(activeDiv == 0)
			{ 
				activeDiv = 1;
				$("#skilldata").toggle(); 
				$("#queuedata").toggle();
			}
			else { }
		});



	        function send_data(qid, cid) {
        	        $.ajax({
                	        type: "POST",
                        	url:'edit_queue.php',
	                        data: ({qid:this.qid, cid:this.cid}),
	                        success: function(data) {
	                                console.log("AJAX success.");
        	                }
                	});

        	}	
	});
</script>