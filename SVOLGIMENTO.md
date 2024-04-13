Creeremo un progetto con laravel11 + react.


REQUISITI: LARAVEL11, REACT, TAILWIND, COMPOSER, XAMPP, BREEZE, INERTIA, VSC,
-------------------------------------------------------
{SPAZIAMENTO DEL TESTO IN VSC}
.editorconfig
[*.{js,jsx}]
indent_size = 2

impostiamo tutti i file .js e .jsx ad una spaziatura di 2 ( standard come piace a noi sarebbe 4 )
-------------------------------------------------------
STEP 1:
{CREAZIONE PROGETTO}
1- aprire vsc, selezionare una cartella vuota( in htdocs di xampp) parire shell in vsc,
 - composer create-project laravel/laravel .
 - composer require laravel/breeze --dev 
 - php artisan breeze:install
	- selezionare " react ", " dark "
Dopo aver installato react con inertia, avvieremo 3 terminali:
- php artisan serve ( rename Serve )
- npm run dev ( rename Vite )
- php artisan tinker ( rename Tinker )
- l'ultimo lo lasciamo a disposizione per i comandi  artian in produzione  ( rename Artisan )

------------------------------------------------------
STEP 2
{DARK THEME}

- apriamo sul browser il nostro localhost:8000/
- se vogliamo modificare l'impostazione del colore del tema laravel da bianco a nero:
- apri file tailwind.config.js -> sotto export default, ma sopra "content", inserire:

- darkMode: 'class', // aggiunto per la customizzazione del tema dark

- aprire il file resources/view/app.blade.php
modifica la stringa:
- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
-------------------------------------------------
STEP 3
{VERIFICA EMAIL}

- User.php ( Model )

- class User extends Authenticatable implements MustVerifyEmail
	- implements MustVerifyEmail serve per la verifica dell'email durante la registrazione
	
	- aprire il file .env e cercare " MAIL_MAILER=log " questo richiama il file laravel.log in :
	- storage/logs/laravel.log
	
{TEST}
Per testare il funzionament odi email verificata, creare un utente in laravel, alal richiesta di confermare l'email andare in laravel.log, cercare la stringa inerente alla conferma : "  Please click the button below to verify your email address.

Verify Email Address: http://localhost:8000/verify-email/2/9820183dba2545651f767d4f01442aa97edd34fb?expires=1712142119&signature=80882eca2d9c11470defeb3a111f11df6770994e2da7382501cccab0ed355aa8

If you did not create an account, no further action is required.

Regards,
Laravel " , 

- cliccare sul link e vedremo che conferemremo al nostra email in pagina.
---------------------------------------------------------------------------------
{SPIEGAZIONI FLASH}
-introduzione zona network per l'ispector.


---------------------------------------------------------------------------------

{CONNECT TO DB}
- Generiamo dal comando del Model,Factory e Migration tramite:
	- php artisan make:model Project -fm
	- php artisan make:model Task -fm
	
- Apriamo le migration e creiamo le colonne del DB:
 es tasks:
	    Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('iamge_path')->nullable();
            $table->string('status');
            $table->string('priority');
            $table->string('due_date')->nullable();
            $table->foreignId('assigned_user_id')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->foreignId('project_id')->constrained('projects');
            $table->timestamps();
        });
		
- Apriamo le Factories:
es task:

			public function definition(): array
    {
        return [
            'name'=> fake()->sentence(),
            'description' => fake()->realText(),
            'due_date' => fake()->dateTimeBetween('now', '+1 year'),
            'status' => fake()->randomElement(['pending','in_progress','completed']),
            'priority'=> fake()->randomElement(['low','medium','high']),
            'image_path' => fake()->imageUrl(),
            'assigned_user_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
	
- impostiamo nel nostro DatabaseSeeder.php:

 public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'DevL',
            'email' => 'luca@luca.it',
            'password' => bcrypt('12345678'),
            'email_verified_at' => time(),
        ]);

        Project::factory()
                ->count(30)
                ->hasTasks(30)
                ->create();
    }
	
---------------------------------------------------------------------------------------
{RELAZIONI CON IL DB TRA TABELLE}

Models/Project.php
		public function tasks(){
			
			return $this->hasMany(Task::class);
			
		}
----------------------------------------------------------------------------------------
{TINKER}

- Permette di fare delle query direttamente da console. e sono molto utili.
- In questo caso, essendo che stiamo facendo delle migrazioni sul db e degli inserimenti dati, grazie a tinker possiamo richiamare direttamente quelle stringhe su console.
ad esempio stampiamo i primi 5 prodotti disponibili in task, oppure controlliamo quante task ci sono o quanti progetti.

PS C:\xampp\htdocs\laravel-react-inertia> php artisan tinker
Psy Shell v0.12.3 (PHP 8.2.12 — cli) by Justin Hileman
> \App\Models\Project::count()                                                                                                     
= 30

> \App\Models\Task::count()                                                                                                        
= 900

> \App\Models\Task::query()->paginate(5)->all() //NE STAMPA 5                                                                     
= [
    App\Models\Task {#6122
      id: 1,
      name: "Suscipit beatae sequi tempora consequuntur ut repudiandae corrupti.",
      description: "These were the cook, to see that queer little toss of her knowledge. 'Just think of nothing else to say when I get it home?' when it saw mine coming!' 'How do you want to go through next walking.",
      image_path: "https://via.placeholder.com/640x480.png/0011aa?text=ea",
      status: "in_progress",
      priority: "medium",
      due_date: "2024-12-02 06:14:40",
      assigned_user_id: 1,
      created_by: 1,
      updated_by: 1,
      project_id: 1,
      created_at: "2024-04-03 14:51:15",
      updated_at: "2024-04-03 14:51:15",
    },
    App\Models\Task {#6121
      id: 2,
      name: "Eum sunt perferendis pariatur ea quos nulla.",
      description: "ME,' said Alice indignantly. 'Ah! then yours wasn't a really good school,' said the voice. 'Fetch me my gloves this moment!' Then came a rumbling of little Alice herself, and shouted out, 'You'd.",
      image_path: "https://via.placeholder.com/640x480.png/005533?text=autem",
      status: "in_progress",
      priority: "low",
      due_date: "2024-06-07 21:16:14",
      assigned_user_id: 1,
      created_by: 1,
      updated_by: 1,
      project_id: 1,
      created_at: "2024-04-03 14:51:15",
      updated_at: "2024-04-03 14:51:15",
    },
    App\Models\Task {#6120
      id: 3,
      name: "Accusamus qui dolorem quae animi.",
      description: "Alice replied thoughtfully. 'They have their tails in their proper places--ALL,' he repeated with great curiosity, and this was his first speech. 'You should learn not to lie down on their faces, so.",
      image_path: "https://via.placeholder.com/640x480.png/004444?text=quisquam",
      status: "pending",
      priority: "low",
      due_date: "2024-06-27 02:42:43",
      assigned_user_id: 1,
      created_by: 1,
      updated_by: 1,
      project_id: 1,
      created_at: "2024-04-03 14:51:15",
      updated_at: "2024-04-03 14:51:15",
    },
    App\Models\Task {#5155
      id: 4,
      name: "Quia repellendus est sunt aperiam cum.",
      description: "I've fallen by this time.) 'You're nothing but the great concert given by the hedge!' then silence, and then treading on my tail. See how eagerly the lobsters and the other players, and shouting.",
      image_path: "https://via.placeholder.com/640x480.png/004499?text=quia",
      status: "in_progress",
      priority: "low",
      due_date: "2024-06-07 23:28:55",
      assigned_user_id: 1,
      created_by: 1,
      updated_by: 1,
      project_id: 1,
      created_at: "2024-04-03 14:51:15",
      updated_at: "2024-04-03 14:51:15",
    },
    App\Models\Task {#5156
      id: 5,
      name: "Est beatae mollitia voluptatem sit voluptatem.",
      description: "Mock Turtle. 'And how did you call him Tortoise, if he had taken advantage of the hall; but, alas! the little door, had vanished completely. Very soon the Rabbit noticed Alice, as she had this fit).",
      image_path: "https://via.placeholder.com/640x480.png/005588?text=quas",
      status: "completed",
      priority: "high",
      due_date: "2024-07-13 12:18:34",
      assigned_user_id: 1,
      created_by: 1,
      updated_by: 1,
      project_id: 1,
      created_at: "2024-04-03 14:51:15",
      updated_at: "2024-04-03 14:51:15",
    },
  ]

>                               
-------------------------------------------------------------------------------
{CONTROLLER}
- Dopo aver provato che le nostre tabelle e i nostri dati ci sono e funzionano, creiamo il conroller:
- creiamo i controller che ci fanno utilizzare sia le request che le resource.
es: 
	- php artisan make:controller ProjectController --model=Project --requests --resource
	- il --model=Project gli specifica che quello è il suo model di appartenenza.
	- Ricordiamo che:
		- Requests crea UpdateProjectRequest e StoreProjectRequest
		- Resource permette di popolare gia il controller ed aggiungere le varie Dependency Injection

- Creati i controller per User, Project, Task :
	- routes/web.php	
		- Creiamo dei middleware per le rotte:
			- //MIDDLEWERE con arrow function
				Route::middleware(['auth', 'verified'])->group(function () {
					Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

					Route::resource('project', ProjectController::class);
					Route::resource('task', TaskController::class);
					Route::resource('user', UserController::class);
				});
			- Le rotte si controllano semre dopo averle scritte: 
				- php artisan route:list
				
----------------------------------------------------------------------------------------
{ROTTE CRUD INDEX}
adesso iniziamo ad importare le rotte nel layout, in modo da poter testare le CRUD:
troveremo la parte dell'header del layout in: -> resources/js/Layouts/AuthenticatedLayout.jsx 
(in realta ci roveremo una funzione export default con il nome Authenticated , noi dovremmo modificarlo in AuthenticatedLayout per rispettare la coerenza anche con il file e con gli altri import export gia esistenti.)
e creiamo i nostri
link:componenti :


		<div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
			<NavLink href={route('user.index')} active={route().current('user.index')}>
				Users
			</NavLink>
		</div>
		

-adesso sappiamo che ovviamente non funzionano perche mancano le pagine di riferimento e vanno create, partiamo con la pagina del Project/index.jsx e creiamo la funzione Index(){}

- nel nostro index.jsx, essendo una rotta accedibile solo tramite il login, necessita nel suo corpo il tag <AuthenticatedLayout .... >
	-es:	
		//LAYOUT USER AUTENTICATO.
		import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
		import { Head } from "@inertiajs/react";

		export default function Index({auth, project}){
			return(
				<AuthenticatedLayout
					user={auth.user}
					header=
					{<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
						PROJECTS
					</h2>}
				>
				<Head title="Project" />

				<div className="py-12">
					<div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
						<div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
							<div className="p-6 text-gray-900 dark:text-gray-100">Projects</div>
						</div>
					</div>
				</div>

				</AuthenticatedLayout>
			)
		}


{INDEX}
- nel controller adatto, rempiamo/creiamo la funzione index(){....};
	es:
		
		 public function index()
		{
			$query = Project::query();
			$projects = $query->paginate(10);
			return Inertia("Project/Index", [
				"projects" => ProjectResource::collection($projects)],);
		}
		
- Creiamo un Resource:
	- php artisan make:resource ProjectResource
		- in Laravel serve a creare una nuova classe Resource. Le risorse sono utilizzate per trasformare i modelli Eloquent in un formato personalizzato, solitamente JSON, per essere inviati come risposta dalle API. Questa classe di risorsa può essere personalizzata per includere solo i dati necessari, per rinominare i campi o per aggiungere ulteriori trasformazioni ai dati.
		
		------------------------------
	Http\Resources\ProjectResource-->
		
		
		public function toArray(Request $request): array
		{
			// return parent::toArray($request);

			return [

				"id"=> $this->id,
				"name"=> $this->name,
				"description"=> $this->description,
				"created_at"=> (new Carbon($this->created_at ))->format("Y-m-d H:i:s"),
				"due_date"=> (new Carbon($this->due_date ))->format("Y-m-d H:i:s"),
				"status"=> $this->status,
				"image_path"=> $this->image_path,
				"createdBy"=> $this->createdBy,
				"updatedBy"=> $this->updatedBy,
			];
		}
		//Carbon è come le facades di Illuminate.
	Models\Project-->
	
	//RELAZIONIAMO LE COLONNE DELLE DUE TABELLE ( USER E PROJECT )
	public function createdBy(){
		return $this->belongsTo(User::class, 'created_by');
	}
	public function updatedBy(){
		return $this->belongsTo(User::class, 'updated_by');

	}
		------------------------------
	
	Index.jsx adesso verra mostrato a schermo, per testare richiamiamo un JSON nella pagina dove verranno mostrati i vari elementi:
		- <pre>{JSON.stringify(projects, undefined, 2)}</pre>
		
		
	-----{IMMAGINI}-----
	- RICORDA:
		- le immagini create dal fakerPHP, devono essere gestite senza gli apici ma con le graffe
		<img src={project.image_path} />
		
		{STYLE in TAG}
		
		style={{width:60 , background: 'white' }}
	-----------------------
	
	{PAGINAZIONE : NUMERI E FRECCE PER CAMBIARE PAGINA (AVANTI E INDIETRO)  AI PRODOTTI}
	
		- Creiamo un file in js/Components -> Pagination.jsx
		// links è una props( capire bene dio cane)
		
		export default function Pagination({links}) {
			return(
					<nav className="text-center mt-4">
						{links.map(link =>(
							<Link
								preserveScroll 
								href={link.url || ""}
								key={link.label}
								className={
								"inline-block py-2 px-3 rounded-lg text-gray-200 text-xs " +
								(link.active ? "bg-gray-950" : " ") +
								(!link.url ? "!text-gray-500 cursor-not-allowed" : "hover:bg-gray-950")
						}
							dangerouslySetInnerHTML={{__html: link.label}}></Link>
							//permette di visualizzare le "entità oggetto per html" 
						))}
					</nav>
			
			)
		}
		------{ATTRIBUTI}------
		preserveScroll  // permette che al cambio di pagina si rimanga direttamente all'altezza di dove si era l'ultima volta, ad esempio per le single application è consigliato usarlo per preservare il punto in cui si era originamentoe prima del cambio pagina
		-------------------------
		-------{SOLUZIONE AL PROBLEMA DEL LINK ATTIVO:}------
			- Il link attivo in questo contesto in realta è una classe concatenata, lo dicono anche le {}, infatti essendo una serie di concatenazioni, tutte le varie scritture e modifiche come "bg-gray-950" , ha bisogno che ci sia uno spazio alla fine della sua scrittura, qundi:
			"bg-gray-950 " , cosi permetteremo la concatenazione che avviene con il " + " .
			Applicando questa logica, possiamo notare come anche " text-xs" abbia bisogno dello spazio finale per far funzionare le altre eventuali classi aggiunte tramire un evento.
			
		----------------------------------------------------- 
		
		- sotto al table per visualizzare tutti i nostri prodotti nel file index.jsx , inseriamo questo nuovo tag funzione creato:
			</table>
			<Pagination link={projects.meta.links} />
	
--------------------------------------------------------------------------------------------

	ovviamente stampare il nome delle colonne non è la migliore delle pratiche, infatti utilizzeremo un sistema per modificare a livello globale quelle variabili, classi, etc, che servono per un discorso di user friendly.
	
	creiamo in : resources/js/constants.jsx
	
	- creeremo tutte costanti export :
		export const PROJECT_STATUS_CLASS_MAP = {

			'pending' : 'bg-amber-500',
			'in_progress' : 'bg-blue-500',
			'completed' : 'bg-green-500',

		}
		export const PROJECT_STATUS_TEXT_MAP = {

			'pending' : 'Pending',
			'in_progress' : 'In Progress',
			'completed' : 'Competed',

		}
	- lo faremo sia per che per TASK_PRIORITY( alta media o bassa ) 
	creato questo file, torniamo nell'index.jsx e:
	
		<td className="px-3 py-2">
			{PROJECT_STATUS_TEXT_MAP[project.status]}
		</td>
		
		con classe aggiunta per i colori:
			 <td>
				<span className={
					"px-2 py-1 rounded text-white " +
					PROJECT_STATUS_CLASS_MAP[project.status]
				}>

				{PROJECT_STATUS_TEXT_MAP[project.status]}
				</span>
			</td>
		
FINO AD ORA: 
CREAZIONE TABELLE, PAGINAZIONE, CRUD(r), AUTH, MIDDLEWERE, VERIFICA EMAIL, TESTING, ...

--------------------------------------------------------------------
{IMPLEMENTAZIONE FILTRAGGIO}
	
	- nel file index.jsx, creiamo un secondo <thead> a cui assegneremo il ruolo di filtro, svuotiamo tutti i campi e insieriamo il tag precostruito da React e Breeze che è <TextImput />
	
	- andiamo in js/Components/ e dupliciamo TextInput.jsx e rinominiamolo in SelectInput.jsx
	
	- in SelectInput.jsx modifichiamo il nome della funzione da TextInput a SelectInut, modifichiamo il tag input in select, quindi elimineremo  il tag-close e creeremo la chiusura della select, nel mezzo creeremo una variabile children che richiameremo anche nell'import della funzione SelectInput
	Timuoviamo il type sia richiamato nella select che nell'import della funzione, perche è per gli input e non per le select, rimuoviamo anche //isFocused = false, e useEffect dal richiamo di funzione
	- rimuoviamo anche il tag " useEffect " dall'import principale.
	
	-tag <TextInput /> : 
	gli passiamo dei parametri e attributi come : onBlur , onChange , className , onKeyPress:
	
		- onBlur={e => searchFieldChanged('name', e.target.value)}
          onKeyPress={e => onKeyPress('name', e)}
		  
		  -	adesso definiamo le funzioni : searchFieldChanged e onKeyPress:
			-	prima passiamo un valore alla funzione genitore Index,{queryParams=null}
			-	poi definiamo che :     
				queryParams = queryParams || {}
				const searchFieldChanged =(name, value) => {
					if(queryParams){
						queryParams[name] = value;

					}else{
						delete queryParams[name];
					}
				}
				
				const onKeyPress = (name, e) => {

					if(e.key !== 'Enter') return;

					searchFieldChanged(name, e.target.value)
				}
				
		
		
		- nel file index.jsx , aggiungiamo al tag SelectInput un tag di chiusura ed al suo interno impotiamo degli option value = pending,in_progress,completed
		
		
		adesso testiamo tutto in delle rotte, per il momento abbiamo la visuale sul cambio dello stato nel'url, ovvero che se useremo la select per selezionare " pending ", l'url cambiera in / status=pending ( manca la view ancora) stessa cosa per la TextInput.
		
		andiamo in index.jsx -> Index() -> searchFieldChanged() ed usiamo il router di Inertia:
			- router.get(route('project.index'),queryParams)
		

		-ProjectController.php
		
	
	



























