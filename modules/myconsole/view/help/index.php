<?php

if (!empty($controllerData)) {
			foreach ($controllerData as $data => $info) {			
				if (is_array($info)) {
					foreach($info as $infoValue) {
						if ($infoValue ->{'name'} !== "__construct") {
							echo $cleanfunction->cleanFileName($infoValue ->{'name'});
							echo "\n";
						}
					}
				}
			}
		}
		
?>