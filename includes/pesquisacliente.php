
<style type="text/css">
	
	body{ font-family:"Trebuchet MS", Arial, Helvetica, sans-serif }
	
	/* > Para o input */
	.input-search2{
		border:1px solid #CCC;
		padding:5px 14px;
		font-size:12px;
		margin:00px 0px;
		float:right;
		
		-webkit-border-radius:15px;
		   -moz-border-radius:15px;
		    -ms-border-radius:15px;
		     -o-border-radius:15px;
		        border-radius:15px;
	}
		.input-search2::-webkit-input-placeholder{ font-style:italic }
		.input-search2:-moz-placeholder			{ font-style:italic }
		.input-search2:-ms-input-placeholder		{ font-style:italic }
	
	table.lista-clientes{
		border-collapse:collapse;
		font-size:12px;
		font-family:Tahoma, Geneva, sans-serif;
	}
		table.lista-clientes th{
			padding:5px;
			background:#EEE;
			border:1px solid #CCC;
		}
		table.lista-clientes td{
			padding:3px;
			border:1px solid #CCC;
		}
	
	.cont{
		width:500px;
		margin-top:-20px;
		margin-left:0px;
		overflow:hidden;
	}
	
	.tabelaPesquisaClientes{
	  cursor:pointer; 	
	}
	
</style>
<div class="cont">

    <input type="text" class="input-search2" placeholder="Buscar nesta lista" />
    
    <br style="clear:both">
    <div id="ResultadoPesquisaclientes"> Nenhum Cliente Encontrado </div>
</div>