<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="{{ mix('resources/css/app.css') }}" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<title>Communique</title>
	
</head>
<body class="">
	<div class="text-center mx-auto mt-2 border-2 border-gray-900 p-3 bg-gray-100 max-w-7xl lg:px-6 md:px-4 sm:px-1 xs:px-1">
		<h6 class="letter-spacing-2 flex flex-col items-center gap-y-1 px-4 mt-8">
			<div class="text-sky-400 flex w-full lg:px-7 md:px-3 sm:px-1 xs:px-1">
				<img src="{{asset(env('APP_LOGO'))}}" alt="" style="height: 80px; " class="border rounded-full float-right">
				<span class="flex flex-col font-bold mx-auto">
					<span class="uppercase text-orange-600">
						République du Bénin
					</span>
					<span class="text-gray-800 text-sm">
						Ministère de l'Enseignement Technique et de la Formation Professionnelle
					</span>
					<span class="mx-auto inline-block w-full mt-1">
						<span class="w-full flex mx-auto ">
							<span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
							<span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
							<span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
						</span>
					</span>
                    <h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-gray-800 fas fa-2x letter-spacing-1 flex flex-col">
						<span>{{ env('APP_NAME') }}</span>
                        <span class="text-xs font-mono letter-spacing-1">
                            {{ getAppFullName() }}
                        </span>
					</h3>
					<h4 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-gray-900 my-0 uppercase letter-spacing-1 lg:text-xl md:text-xl sm:text-base xs:text-sm border-2 border-gray-900 py-3 mt-2">
						Communiqué {{ $communique->getCommuniqueFormattedName() }}
					</h4>  
					
				</span>
				<img src="{{asset(env('APP_LOGO'))}}" style="height: 80px" alt="" class="rounded-full float-end border">
			</div>
		</h6>

        <div class="mx-auto w-10/12 mt-6 lg:px-6 md:px-4 sm:px-1 xs:px-1 mb-32">

            <div class="flex justify-between items-center w-full mt-5">
                <div>
                    <div class="flex flex-col">
                        <h6 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="uppercase lg:text-2xl m:text-2xl sm:text-base xs:text-xs font-bold text-gray-950">
                            {{ $communique->from ? $communique->from : "L'administration" }}
                        </h6>
                        <h6>
                            {{ $communique->getCommuniqueFormattedName() }}
                        </h6>
                    </div>
                </div>
                <div>
                    <h6 class="letter-spacing-1 font-semibold text-gray-800 lg:text-lg m:text-lg sm:text-base xs:text-xs"> Cotonou, le {{ __formatDate($communique->created_at) }} </h6>
                </div>
            </div>

            <div class="w-full mx-auto">

                <h3 style="" class="text-center text-lg uppercase text-gray-700 mt-3 flex justify-end gap-x-4 font-bold letter-spacing-1">
                    <span class="underline">Objet: </span>
                    <span>
                        {{ $communique->objet }}
                    </span>
                </h3>

                <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-center text-2xl uppercase text-black underline font-bold letter-spacing-2 mt-3">communiqué</h2>

                <div class="text-left mt-3 mb-2">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est rem in neque quae nisi dolorum magnam, quo, fuga ratione eos libero exercitationem provident a consectetur hic. At illo saepe amet!
                    Deserunt, repudiandae laudantium? In aut optio deserunt mollitia perferendis, voluptatem molestias? Voluptate nostrum ea unde veniam. Suscipit earum dolores unde consequatur error quod, natus, modi animi tenetur laborum eum culpa.
                    Labore minima culpa voluptate eveniet, magni quos nesciunt ut in possimus dignissimos ratione sunt ab, maxime fugit. Dolore, dolorum ab? Fuga nostrum minima eum pariatur dicta repellat nobis dignissimos quaerat!
                    Facere, deleniti quam excepturi vitae saepe nostrum hic necessitatibus iste quas nihil nulla quibusdam expedita labore animi quaerat eveniet quod minima dolorem? Voluptate eligendi maxime iusto rerum optio similique culpa?
                    Iure, perferendis cum suscipit laudantium voluptas provident aspernatur omnis! Quaerat, numquam repudiandae. Doloribus, natus laudantium! Illum laborum amet quo debitis quam, ut impedit, ex beatae qui quos adipisci ea non.
                    Et doloribus voluptatibus pariatur nulla dolores accusamus, consequatur, optio omnis quia maxime molestiae adipisci repellat inventore est laboriosam vero possimus repudiandae. Voluptate repudiandae iusto recusandae beatae unde iure magnam. Vel.
                    Accusantium deserunt repellat laboriosam dolores eveniet aliquam consequuntur dolor tempore dolorum laudantium minima, quae, totam eos nisi explicabo iure nihil fugit asperiores impedit beatae officia aperiam perferendis similique odit. Quibusdam.
                    Totam, sint ea tempora neque accusantium aperiam enim quia numquam, amet unde minus laborum culpa. Reprehenderit, modi perspiciatis sequi at atque, sint omnis doloremque, sit explicabo consequatur libero nisi a?
                    Necessitatibus corporis consectetur quos saepe magni eaque nihil qui dolore rem cumque itaque quia ipsa obcaecati molestias consequuntur voluptate odit ab esse excepturi asperiores, suscipit a explicabo sapiente. Itaque, nobis?
                    Ipsa soluta culpa dolor animi exercitationem. Fuga perspiciatis ipsum reiciendis deserunt veritatis facere molestiae, culpa quas itaque, quibusdam nihil temporibus nobis recusandae. Quis labore illo quasi est voluptate praesentium voluptates.
                </div>
            </div>

            <div class="my-10 flex justify-end">
                <h6 class="letter-spacing-1 font-semibold text-gray-800 lg:text-lg m:text-lg sm:text-base xs:text-xs"> Cotonou, le {{ __formatDate($communique->created_at) }} </h6>

            </div>
            
        </div>
        <span class="mx-auto inline-block w-8/12 mt-1">
            <span class="w-full flex mx-auto ">
                <span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
                <span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
                <span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
            </span>
        </span>
        
	</div>
    <span class="mx-auto inline-block w-full mt-1">
        <span class="w-full flex mx-auto ">
            <span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
            <span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
            <span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
        </span>
    </span>

</body>
</html>