<?php
	if(isset($msgErro) and (trim($msgErro) != "")){
		echo("<div class='alert alert-danger'>" . $msgErro . "</div>");
	}

	if(isset($msgSucesso) and (trim($msgSucesso) != "")){
		echo("<div class='alert alert-success'>" . $msgSucesso . "</div>");
	}
