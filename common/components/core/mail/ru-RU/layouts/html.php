<?php $this->beginPage() ?>
<!DOCTYPE>
<html>
<head>
	<meta charset="<?=Yii::$app->charset?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="date=no">
	<style>
		* {
			box-sizing: border-box;
		}

		div a {
			color: #000 !important;
		}
	</style>
</head>
<body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
	<tr>
		<td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">
			<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
				<tr>
					<td style="font-family: Helvetica, Arial, sans-serif; font-size: 24px; font-weight: bold; padding: 12px; color: #128698;" align="left"><?=Yii::$app->name?></td>
				</tr>
				<tr>
					<td style="padding-top: 12px; padding-bottom: 12px; background-color: #ffffff; padding-left: 24px; padding-right: 24px;" align="left">
						<div style="font-size: 18px; font-weight: 600; color: #333333;"><?=$this->params['title']?></div>
						<br>
						<div style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #333333;">
							<?php $this->beginBody() ?>
							<?=$content?>
							<?php $this->endBody() ?>
							<br>
						</div>
					</td>
				</tr>
				<tr>
					<td style="font-size: 12px; line-height: 16px; color: #aaaaaa; padding: 12px;" align="left">
						<br>
						<?=date("Y")?> &copy; <?=Yii::$app->name?>
						<br><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
<?php $this->endPage() ?>