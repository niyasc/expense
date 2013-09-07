<?php
	date_default_timezone_set('Asia/Calcutta');
?>
<table class='table table-striped table-bordered' style="width:1200px;margin-left:auto;margin-right:auto">
	<tr>
		<td style="width:200px">
			<?php require("../templates/member_menu.php") ?>
		</td>
		<td>
			<table style="width:700px">
				<tr>
					<td>
					<h3>Add Record</h3>
					</td>
				</tr>

				<?php
					if(!empty($values["error"]))
					{
				?>
				<tr>
					<td style="text-align:center">
					<label class="label label-important">
					<?=$values["error"]?>
					</label>
					</td>
				</tr>
				<?php
					}
					
				?>
				
				<?php
					if(!empty($values["message"]))
					{
				?>
				<tr>
					<td style="text-align:center">
					<label class="label label-success">
					<?=$values["message"]?>
					</label>
					</td>
				</tr>
				<?php
					}
					
				?>
					
				<form method="post" action="add-entry.php">
				<tr>
					<td style="text-align:center;margin-left:auto;margin-right:auto">
					
						<table class='table table-striped table-bordered' style="margin-left:auto;margin-right:auto">
							<tr>
								<td>
									Date
								</td>
								<td>
									<input type="date" name="date" placeholder="Date" required="" value="<?=date('Y-m-d')?>"/>
								</td>
							</tr>
							<tr>
								<td>
									Item
								</td>
								<td>
									<input type="text" name="item" placeholder="Item" required=""/>
								</td>
							</tr>
							<tr>
								<td>
									Expense
								</td>
								<td>
									<input type="text" name="price" placeholder="Expense" required=""/>
								</td>
							</tr>
							
						</table>
					</td>
				</tr>
				<tr>
					<td style="text-align:center">
						<input type="submit" class="btn" value="Add Record"/>
					</td>
				</tr>
				</form>
				
			</table>
		</td>
	</tr>
</table>