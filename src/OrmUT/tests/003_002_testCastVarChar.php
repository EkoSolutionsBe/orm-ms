
<p class='title'>003/002 : Test the Cast Mapping with varchar ?</p>
<?php
	
	//First, drop the table, recreate it
	OrmCore::dropTable(new CastOrmUTString());
	OrmCore::createTable(new CastOrmUTString());
	$chaine = "STRING_a€é$    ";
	$buffer = "BUFFER_a€é$<br/>retour\r\nretour     ";
	
	//Test insert
	$cast = new CastOrmUTString();
	$cast->set("aString",$chaine);
	$cast->set("aStringNull",null);
	$cast->set("aBuffer",$buffer);
	$cast->set("aBufferNull",null);
	
	try{
		$cast->save();
		echo "<p class='$cssSuccess'>saving entity with success</p>";
	} catch (Exception $o){
		echo "<p class='$cssError'>Exception during \$cast->save()</p>";
	}
	
	// String null ?
	try{
		$cast->set("aString",null);
		$cast->set("aBuffer",$buffer);
		$cast->save();
		echo "<p class='$cssError'>we expected OrmIllegalArgumentException, that's not okay</p>";
	} catch (OrmIllegalArgumentException $o){
		echo "<p class='$cssSuccess'>As expected we've got a OrmIllegalArgumentException</p>";
	}
	
	// String empty ?
	try{
		$cast->set("aString","");
		$cast->set("aBuffer",$buffer);
		$cast->save();
		echo "<p class='$cssSuccess'>saving entity with success</p>";
	} catch (Exception $o){
		echo "<p class='$cssError'>Exception during \$cast->save()</p>";
	}
		
	// String empty ?
	try{
		$cast->set("aString"," ");
		$cast->set("aBuffer",$buffer);
		$cast->save();
		echo "<p class='$cssSuccess'>saving entity with success</p>";
	} catch (Exception $o){
		echo "<p class='$cssError'>Exception during \$cast->save()</p>";
	}
	
	// BUFFER null ?
	try{
		$cast->set("aString",$chaine);
		$cast->set("aBuffer",null);
		$cast->save();
		echo "<p class='$cssError'>we expected OrmIllegalArgumentException, that's not okay</p>";
	} catch (OrmIllegalArgumentException $o){
		echo "<p class='$cssSuccess'>As expected we've got a OrmIllegalArgumentException</p>";
	}
	
	// BUFFER empty ?
	try{
		$cast->set("aString",$chaine);
		$cast->set("aBuffer","");
		$cast->save();
		echo "<p class='$cssSuccess'>saving entity with success</p>";
	} catch (Exception $o){
		echo "<p class='$cssError'>Exception during \$cast->save()</p>";
	}
	
	// BUFFER empty ?
	try{
		$cast->set("aString",$chaine);
		$cast->set("aBuffer"," ");
		$cast->save();
		echo "<p class='$cssSuccess'>saving entity with success</p>";
	} catch (Exception $o){
		echo "<p class='$cssError'>Exception during \$cast->save()</p>";
	}
	
	//
	$elements = OrmCore::findAll($cast);
	$cast = $elements[0];
	
	UtilsTest::assertIsEquals($cast->get("aString"),$chaine);
	UtilsTest::assertIsNull($cast->get("aStringNull"));
	UtilsTest::assertIsEquals($cast->get("aBuffer"),$buffer);
	UtilsTest::assertIsNull($cast->get("aBufferNull"));
	

	
	//Finally, drop the table
	//OrmCore::dropTable(new CastOrmUTString());
	
?>