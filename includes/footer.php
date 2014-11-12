<!--session timeout prompt -->
<div id="idle_timer">
	<h1>คุณมีเวลาในการใช้งานระบบแต่ละครั้งไม่เกิน <?php echo $inactivity_timeout/1000;?> วินาที</h1>
	<h1>คลิกปุ่ม "ตกลง" หากต้องการอยู่ในระบบต่อไป</h1>
	<h1>ออกจากระบบอัตโนมัติภายใน <span style="color:#b60606">20</span> วินาที</h1>
	<div class="ok_button button" title="selfcheck_button" onclick="tb_remove();">
		<h1>ตกลง</h1>
	</div>
</div>
<!--end session timeout prompt -->

</body>
</html>