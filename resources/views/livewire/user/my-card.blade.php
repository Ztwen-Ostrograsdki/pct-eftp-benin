<div>
    <style type="text/css">
        .cart-container{
            border: thin solid;
            padding: 7px;
            border-radius: 10px;
            text-align: center;
            font-family: sans-serif;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 10px auto;
            width: 600px;
            color: rgb(100, 300, 500);
            
        }
    
        .first{
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
        }
    
        .logo img{
            width: 50px;
        }
    
        
    
        .flag-container span{
            display: inline-block;
            height: 1px;
        }
    
        html.sr .widget {
            visibility: hidden;
        }
    
        .widget-list {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
      background: black;
      border-radius: 8px;
        }
        
        .widget {
        width: 15%;
        height: 50px;
        flex: auto;
        margin: 0.5rem;
        background: white;
        line-height: 50px;
        text-align: center;
        border-radius: 4px;
        }

        .first-flag{
            display: flex;
            
        }
        .last-flag{
            display: flex;
            
        }
        .first-flag .green{
            background-color: green;
            height: 4px; 
            width: 40%
            
        }

        .first-flag .yellow-red{
            width: 60%; 
            display: flex; 
            flex-direction: column; 
            height: 4px;
            
        }

        .first-flag .yellow{
            background-color: yellow; 
            height: 2px; 
            width: 100%
            
        }
        .first-flag .red{
            background-color: red; 
            height: 2px; 
            width: 100%
            
        }

        .last-flag .green{
            background-color: green; padding: 0.5px; width: 33.33%
            
        }

        .last-flag .yellow{
            background-color: yellow; padding: 0.5px; width: 33.33%
            
        }

        .last-flag .red{
            background-color: red; padding: 0.5px; width: 33.33%
            
        }
    </style>
    <div class="cart-container">
		<div class="first">
			<div class="logo">
				<img src="{{asset(env('APP_LOGO'))}}">
			</div>
			<div>
				<div>
					Republique du Bénin
					<div>
						<span class="flag">
				            <span  class="first-flag">
				                <span class="green"></span>
				                <span class="yellow-red" >
				                	<span class="yellow" ></span>
				               	 	<span class="red" ></span>
				                </span>
				            </span>
				        </span>
					</div>
				</div>
				<div>
					Ministère de l'enseigenement technique et de la formation professionnel
				</div>
				<div>
					Association des enseignants de sciences physiques du Bénin
				</div>
			</div>
			<div class="logo">
				<img src="{{asset(env('APP_LOGO'))}}">
			</div>
		</div>
		<div>
			<span class="flag-container">
	            <span style="display: flex;" class="last-flag">
	                <span  class="green"></span>
	                <span   class="yellow"></span>
	                <span   class="red"></span>
	            </span>
	        </span>
		</div>
		<div class="card-body">

			
		</div>
	</div>
</div>
