<?php
/**
 * @package LikeParrot
 */
/*
Plugin Name: LikeParrot
Plugin URI: http://likeparrot.com/
Description:  Chat service that allows you to connect in real time with users of your website. Take customer service to a higher level in an online environment. Chat with them and generate long-term relationships with Likeparrot.

Author: SYSTEMICO
Version: 1.1.2
Author URI: https://systemico.co/
License: GPLv2 or later
Text Domain: LikeParrot
*/

/*

*/


add_action('admin_menu', 'likeparrot_menu_pages');
add_action('admin_init', 'likeparrot_registrar_campos');
add_filter('wp_footer', 'likeparrot_mostrar_chat');



function likeparrot_registrar_campos(){
        add_settings_section("section", "Likeparrot", null, "theme-options");
	add_settings_field("likeparrot_usuario","", "", "theme-options", "section");
	add_settings_field("likeparrot_onlyuser","", "", "theme-options", "section");
	register_setting("section", "likeparrot_usuario");
	register_setting("section", "likeparrot_onlyuser");
    }

function likeparrot_mostrar_chat(){
	wp_enqueue_script('likeparrot_script','https://app.likeparrot.com/private/integration/likeparroti.js');
	wp_enqueue_style('likeparrot_style', 'https://app.likeparrot.com/private/integration/estilos/estilos.css'); 
	if(get_option('likeparrot_usuario','')!=""){
	$usuario=strtolower(get_option('likeparrot_usuario',''));
	$user=$usuario;
	$usuario=explode("@",$usuario);
	if(!isset($usuario[1])){
	$usuario=array();
	$usuario[1]='likeparrot.com';
	$user=$user.'@likeparrot.com';
        }
	$dominio=$usuario[1];
	$dominio=md5($dominio);
	$user=md5($user);
	if($usuario[1]!='likeparrot.com' && get_option('likeparrot_onlyuser')=='')
	$user="";
		echo '<script type="text/javaScript">likeparrotu="'.$user.'"; likeparrotdom="'.$dominio.'"; </script>';
	}
	else
		echo '<script type="text/javaScript">likeparrotu=""; likeparrotdom=""; </script>';
}

function likeparrot_options(){
	 
	?>
	
	<div style="width: 48%; display: inline-block;vertical-align:top;" >
	<form method='post' action='options.php'>
	<center>	
	
	<?php
	settings_fields("section");
	//do_settings_sections("theme-options");  
        ?>
	<h3> Plugin Configuration </h3>
        <div>Username (example: user@domain.co)</div><br>
        <div><input placeholder="user@domain.co" name="likeparrot_usuario" id="likeparrot_usuario" value="<?php echo get_option('likeparrot_usuario'); ?>"  type="text"></div><br>
    	
        <div><input type="checkbox" <?php echo get_option('likeparrot_onlyuser'); ?>  value='checked' name="likeparrot_onlyuser"> Only user@domain.co may attend this web site</div>
        <p class="submit" style="margin: 0px; width: 124px;"><input type="submit" value="Guardar cambios" class="button button-primary" id="submit" name="submit"></p>
	<?php // submit_button();
	
	 ?>
	
	</center>
	</form>	
	</div>
        
	
	<div style="width: 48%; display: inline-block;" >
	<center><h3> I don't have an account </h3></center>
	<center><div><img  src="<?php echo plugins_url( 'assets/logo.jpeg' , __FILE__ )?>" alt="" style='width:100%;'></div></center><br>
	<div>  Chat service that allows you to connect in real time with users of your website. Take customer service to a higher level in an online environment. Chat with them and generate long-term relationships with Likeparrot.
	</div><br>
	<center><div> <button type="button" class='button button-primary' onclick="window.open('https://signup.likeparrot.com/','_blank')" >Sign up free </button></div></center>
	</div>

        <?php
       
}

function likeparrot_menu_pages(){
    
    add_menu_page('LikeParrot', 'LikeParrot', 'manage_options', 'likeparrot_menu', 'likeparrot_options' );
}



