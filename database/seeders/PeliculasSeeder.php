<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peliculas;// ¡Asegúrate de que esta línea esté presente!

class PeliculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Elimina todos los registros existentes para evitar duplicados en cada ejecución.
        Peliculas::truncate();

        // 2. Inserta los datos de prueba usando el método create() de Eloquent.
        Peliculas::create([
            'title' => 'El Caballero Oscuro',
            'description' => 'Tras el asesinato del fiscal Harvey Dent, Batman asume la responsabilidad de los crímenes de Dent para proteger su reputación y la esperanza que representa.',
            'poster_url' => 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=kmJLuwP3MbY',
            'duration_minutes' => 152,
            'genre' => 'Acción, Crimen',
        ]);

        Peliculas::create([
            'title' => 'Parásitos',
            'description' => 'La codicia y la discriminación de clase amenazan la relación simbiótica recién formada entre la rica familia Park y la pobre familia Kim.',
            'poster_url' => 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=SEUXfv87Wpk',
            'duration_minutes' => 132,
            'genre' => 'Comedia negra, Thriller',
        ]);

        Peliculas::create([
            'title' => 'Dune',
            'description' => 'Un joven brillante y talentoso, Paul Atreides, debe viajar al planeta más peligroso del universo para asegurar el futuro de su familia y su pueblo.',
            'poster_url' => 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=8g18jFHCLXk',
            'duration_minutes' => 155,
            'genre' => 'Ciencia Ficción, Aventura',
        ]);

        Peliculas::create([
            'title' => 'Inception',
            'description' => 'Un ladrón que roba secretos corporativos mediante el uso de tecnología de compartir sueños recibe la tarea inversa de plantar una idea en la mente de un CEO.',
            'poster_url' => 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
            'duration_minutes' => 148,
            'genre' => 'Ciencia Ficción, Acción',
        ]);

        Peliculas::create([
            'title' => 'Interestelar',
            'description' => 'Un equipo de exploradores viaja a través de un agujero de gusano en el espacio en un intento de asegurar la supervivencia de la humanidad.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BZjdkOTU3MDktN2IxOS00OGEyLWFmMjktY2FiMmZkNWIyODZiXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
            'duration_minutes' => 169,
            'genre' => 'Ciencia Ficción, Drama',
        ]);

        Peliculas::create([
            'title' => 'Matrix',
            'description' => 'Un programador descubre que la realidad tal como la conoce es una simulación creada por máquinas y se une a una rebelión para luchar contra ellas.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNzQzOTk3OTAtNDQ0Zi00ZTVkLWI0MTEtMDllZjNkYzNjNTc4L2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=vKQi3bBA1y8',
            'duration_minutes' => 136,
            'genre' => 'Ciencia Ficción, Acción',
        ]);

        Peliculas::create([
            'title' => 'El Señor de los Anillos: La Comunidad del Anillo',
            'description' => 'Un hobbit de la Comarca y ocho compañeros emprenden un viaje para destruir el poderoso Anillo Único y salvar la Tierra Media del Señor Oscuro Sauron.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BN2EyZjM3NzUtNWUzMi00MTgxLWI0NTctMzY4M2VlOTdjZWRiXkEyXkFqcGdeQXVyNDUzOTQ5MjY@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=V75dMMIW2B4',
            'duration_minutes' => 178,
            'genre' => 'Fantasía, Aventura',
        ]);

        Peliculas::create([
            'title' => 'Avengers: Endgame',
            'description' => 'Después de los devastadores eventos de Infinity War, los Vengadores restantes deben reunirse una vez más para deshacer las acciones de Thanos y restaurar el orden en el universo.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTc5MDE2ODcwNV5BMl5BanBnXkFtZTgwMzI2NzQ2NzM@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
            'duration_minutes' => 181,
            'genre' => 'Acción, Superhéroes',
        ]);

        Peliculas::create([
            'title' => 'Joker',
            'description' => 'En la decadente Ciudad Gótica de 1981, Arthur Fleck, un comediante fracasado, es empujado hacia la locura y se convierte en un asesino psicópata conocido como el Joker.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=zAGVQLHvwOY',
            'duration_minutes' => 122,
            'genre' => 'Drama, Crimen',
        ]);

        Peliculas::create([
            'title' => 'Spider-Man: No Way Home',
            'description' => 'Con la identidad de Spider-Man ahora revelada, Peter pide ayuda al Doctor Strange, pero cuando un hechizo sale mal, los enemigos más peligrosos de otros mundos comienzan a aparecer.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BZWMyYzFjYTYtNTRjYi00OGExLWE2YzgtOGRmYjAxZTU3NzBiXkEyXkFqcGdeQXVyMzQ0MzA0NTM@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=JfVOs4VSpmA',
            'duration_minutes' => 148,
            'genre' => 'Acción, Superhéroes',
        ]);

        Peliculas::create([
            'title' => 'Avatar',
            'description' => 'Un marine parapléjico enviado al planeta Pandora en una misión única se debate entre seguir sus órdenes y proteger al mundo que siente como su hogar.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BZDA0OGQxNTItMDZkMC00N2UyLTg3MzMtYTJmNjg3Nzk5MzRiXkEyXkFqcGdeQXVyMjUzOTY1NTc@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=5PSNL1qE6VY',
            'duration_minutes' => 162,
            'genre' => 'Ciencia Ficción, Aventura',
        ]);

        Peliculas::create([
            'title' => 'Titanic',
            'description' => 'Un aristócrata de diecisiete años se enamora de un artista amable pero pobre a bordo del lujoso y desafortunado R.M.S. Titanic.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMDdmZGU3NDQtY2E5My00ZTliLWIzOTUtMTY4ZGI1YjdiNjk3XkEyXkFqcGdeQXVyNTA4NzY1MzY@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=kVrqfYjkTdQ',
            'duration_minutes' => 194,
            'genre' => 'Romance, Drama',
        ]);

        // ============== TERROR ==============
        Peliculas::create([
            'title' => 'El Conjuro',
            'description' => 'Investigadores paranormales Ed y Lorraine Warren trabajan para ayudar a una familia aterrorizada por una presencia oscura en su granja.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTM3NjA1NDMyMV5BMl5BanBnXkFtZTcwMDQzNDMzOQ@@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=k10ETZ41q5o',
            'duration_minutes' => 112,
            'genre' => 'Terror, Suspenso',
        ]);

        Peliculas::create([
            'title' => 'It (Eso)',
            'description' => 'Siete amigos de la infancia se reúnen para luchar contra un monstruo que acecha en su ciudad natal y que toma la forma del payaso Pennywise.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BZDVkZmI0YzAtNzdjYi00ZjhhLWE1ODEtMWMzMWMzNDA0NmQ4XkEyXkFqcGdeQXVyNzYzODM3Mzg@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=7HJibxdJFCo',
            'duration_minutes' => 135,
            'genre' => 'Terror, Suspenso',
        ]);

        Peliculas::create([
            'title' => 'Un Lugar en Silencio',
            'description' => 'Una familia debe vivir en silencio mientras se esconde de monstruos con audición ultrasensible que cazan por el sonido.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMjI0MDMzNTQ0M15BMl5BanBnXkFtZTgwMTM5NzM3NDM@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=WR7cc5t7tv8',
            'duration_minutes' => 90,
            'genre' => 'Terror, Drama',
        ]);

        Peliculas::create([
            'title' => 'El Resplandor',
            'description' => 'Un escritor, su esposa y su hijo psíquico pasan el invierno en un hotel aislado donde una presencia siniestra influye en el padre hacia la violencia.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BZWFlYmY2MGEtZjVkYS00YzU4LTg0YjQtYzY1ZGE3NTA5NGQxXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=5Cb3ik6zP2I',
            'duration_minutes' => 146,
            'genre' => 'Terror, Drama',
        ]);

        Peliculas::create([
            'title' => 'Hereditary',
            'description' => 'Una familia en duelo es acosada por tragedias trágicas y misterios perturbadores después de la muerte de su secreta abuela.',
            'poster_url' => 'https://m.media-amazon.com/images/S/pv-target-images/2be98bed028f1d53e01a860b6bb91c362dc32611c45effbcf2aa2645d590b22a.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=V6wWKNij_1M',
            'duration_minutes' => 127,
            'genre' => 'Terror, Drama',
        ]);

        // ============== ANIME ==============
        Peliculas::create([
            'title' => 'El Viaje de Chihiro',
            'description' => 'Durante el traslado de su familia a los suburbios, una niña de diez años deambula por un mundo gobernado por dioses, brujas y espíritus, donde los humanos se transforman en bestias.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMjlmZmI5MDctNDE2YS00YWE0LWE5ZWItZDBhYWQ0NTcxNWRhXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=ByXuk9QqQkk',
            'duration_minutes' => 125,
            'genre' => 'Anime, Fantasía',
        ]);

        Peliculas::create([
            'title' => 'Your Name (Kimi no Na wa)',
            'description' => 'Dos adolescentes comparten una conexión profunda y mágica al descubrir que están intercambiando cuerpos. Las cosas toman un giro cuando la niña desaparece.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BODRmZDVmNzUtZDA4ZC00NjhkLWI2M2UtN2M0ZDIzNDcxYThjL2ltYWdlXkEyXkFqcGdeQXVyNTk0MzMzODA@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=xU47nhruN-Q',
            'duration_minutes' => 106,
            'genre' => 'Anime, Romance',
        ]);

        Peliculas::create([
            'title' => 'Demon Slayer: Mugen Train',
            'description' => 'Tanjiro y sus compañeros se embarcan en una nueva misión a bordo del Tren Mugen para investigar la desaparición de más de cuarenta personas.',
            'poster_url' => 'https://preview.redd.it/9l40d2pxgjb71.png?width=640&crop=smart&auto=webp&s=368f37f37a416a53688bdd11a2d557fc7092a1d9',
            'video_url' => 'https://www.youtube.com/watch?v=ATJYac_dORw',
            'duration_minutes' => 117,
            'genre' => 'Anime, Acción',
        ]);

        Peliculas::create([
            'title' => 'Akira',
            'description' => 'Un motociclista de pandilla se convierte en un psíquico desenfrenado y solo dos adolescentes y un grupo de psíquicos pueden detenerlo.',
            'poster_url' => 'https://i.pinimg.com/736x/5f/ef/e8/5fefe8cb134bcfd37d1c6d5e0de7f3c7.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=nA8KmHC2Z-g',
            'duration_minutes' => 124,
            'genre' => 'Anime, Ciencia Ficción',
        ]);

        Peliculas::create([
            'title' => 'La Princesa Mononoke',
            'description' => 'En un viaje para encontrar la cura de una maldición de un demonio Tatarigami, Ashitaka se encuentra en medio de una guerra entre los dioses del bosque y Tatara.',
            'poster_url' => 'https://preview.redd.it/princess-mononoke-imax-poster-clean-v0-e4yudf75dvse1.jpg?width=640&crop=smart&auto=webp&s=d5e86fcbbf365f87871a0bc02cea83005209197c',
            'video_url' => 'https://www.youtube.com/watch?v=4OiMOHRDs14',
            'duration_minutes' => 134,
            'genre' => 'Anime, Fantasía',
        ]);

        // ============== DRAMA ==============
        Peliculas::create([
            'title' => 'Forrest Gump',
            'description' => 'Las presidencias de Kennedy y Johnson, los eventos de Vietnam, Watergate y otras historias se desarrollan a través de la perspectiva de un hombre de Alabama.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNWIwODRlZTUtY2U3ZS00Yzg1LWJhNzYtMmZiYmEyNmU1NjMzXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=bLvqoHBptjg',
            'duration_minutes' => 142,
            'genre' => 'Drama, Romance',
        ]);

        Peliculas::create([
            'title' => 'La Lista de Schindler',
            'description' => 'En la Polonia ocupada por los alemanes durante la Segunda Guerra Mundial, el industrial Oskar Schindler se preocupa gradualmente por su fuerza laboral judía.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNDE4OTMxMTctNmRhYy00NWE2LTg3YzItYTk3M2UwOTU5Njg4XkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=gG22XNhtnoY',
            'duration_minutes' => 195,
            'genre' => 'Drama, Histórico',
        ]);

        Peliculas::create([
            'title' => 'En Busca de la Felicidad',
            'description' => 'Un vendedor en apuros se hace cargo de su hijo mientras se embarca en una pasantía profesional desafiante.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTQ5NjQ0NDI3NF5BMl5BanBnXkFtZTcwNDI0MjEzMw@@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=89Kq8SDyvfg',
            'duration_minutes' => 117,
            'genre' => 'Drama, Biografía',
        ]);

        Peliculas::create([
            'title' => 'The Shawshank Redemption',
            'description' => 'Dos hombres encarcelados se unen a lo largo de varios años, encontrando consuelo y eventual redención a través de actos de decencia común.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=PLl99DlL6b4',
            'duration_minutes' => 142,
            'genre' => 'Drama',
        ]);

        Peliculas::create([
            'title' => 'El Pianista',
            'description' => 'Un músico judío polaco lucha por sobrevivir a la destrucción del gueto de Varsovia durante la Segunda Guerra Mundial.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BOWRiZDIxZjktMTA1NC00MDQ2LWEzMjUtMTliZmY3NjQ3ODJiXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=BFwGqLa_oAo',
            'duration_minutes' => 150,
            'genre' => 'Drama, Guerra',
        ]);

        // ============== ACCIÓN ==============
        Peliculas::create([
            'title' => 'Mad Max: Fury Road',
            'description' => 'En un mundo post-apocalíptico, Max se une a Furiosa para escapar de un líder de culto y sus seguidores.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BN2EwM2I5OWMtMGQyMi00Zjg1LWJkNTctZTdjYTA4OGUwZjMyXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=hEJnMQG9ev8',
            'duration_minutes' => 120,
            'genre' => 'Acción, Aventura',
        ]);

        Peliculas::create([
            'title' => 'John Wick',
            'description' => 'Un ex-asesino a sueldo sale de su retiro para rastrear a los gángsters que mataron a su perro y le quitaron todo.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTU2NjA1ODgzMF5BMl5BanBnXkFtZTgwMTM2MTI4MjE@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=C0BMx-qxsP4',
            'duration_minutes' => 101,
            'genre' => 'Acción, Thriller',
        ]);

        Peliculas::create([
            'title' => 'Misión Imposible: Fallout',
            'description' => 'Ethan Hunt y su equipo deben rastrear plutonio robado mientras son perseguidos por asesinos y la CIA.',
            'poster_url' => 'https://m.media-amazon.com/images/I/91EtQD0P0dL._AC_UF894,1000_QL80_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=wb49-oV0F78',
            'duration_minutes' => 147,
            'genre' => 'Acción, Aventura',
        ]);

        Peliculas::create([
            'title' => 'Gladiador',
            'description' => 'Un ex-general romano busca venganza contra el corrupto emperador que asesinó a su familia y lo envió a la esclavitud.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMDliMmNhNDEtODUyOS00MjNlLTgxODEtN2U3NzIxMGVkZTA1L2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=owK1qxDselE',
            'duration_minutes' => 155,
            'genre' => 'Acción, Drama',
        ]);

        Peliculas::create([
            'title' => 'Top Gun: Maverick',
            'description' => 'Después de más de treinta años de servicio, Pete Mitchell continúa desafiando los límites como piloto de pruebas valiente.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BZWYzOGEwNTgtNWU3NS00ZTQ0LWJkODUtMmVhMjIwMjA1ZmQwXkEyXkFqcGdeQXVyMjkwOTAyMDU@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=qSqVVswa420',
            'duration_minutes' => 130,
            'genre' => 'Acción, Drama',
        ]);

        // ============== COMEDIA ==============
        Peliculas::create([
            'title' => 'Superbad',
            'description' => 'Dos amigos de secundaria co-dependientes están a punto de graduarse y enfrentan la separación cuando van a diferentes universidades.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BY2VkMDg4ZTYtN2M3Yy00NWZiLWE2ODEtZjU5MjZkYWNkNGIzXkEyXkFqcGdeQXVyODY5Njk4Njc@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=4eaZ_48ZYog',
            'duration_minutes' => 113,
            'genre' => 'Comedia',
        ]);

        Peliculas::create([
            'title' => '¿Qué Pasó Ayer? (The Hangover)',
            'description' => 'Tres padrinos pierden al novio en una despedida de soltero en Las Vegas y deben retroceder sus pasos para encontrarlo.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNGQwZjg5YmYtY2VkNC00NzliLTljYTctNzI5NmU3MjE2ODQzXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=tcdUhdOlz9M',
            'duration_minutes' => 100,
            'genre' => 'Comedia',
        ]);

        Peliculas::create([
            'title' => 'Tropic Thunder',
            'description' => 'A través de una serie de eventos extraños, un grupo de actores que están filmando una película de guerra de gran presupuesto se ven obligados a convertirse en los soldados que están interpretando.',
            'poster_url' => 'https://m.media-amazon.com/images/I/81Vjq3W0aTL._AC_UF894,1000_QL80_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=BzVCkHHcJJI',
            'duration_minutes' => 107,
            'genre' => 'Comedia, Acción',
        ]);

        Peliculas::create([
            'title' => 'Step Brothers',
            'description' => 'Dos hombres perezosos de cuarenta años se ven obligados a vivir juntos cuando sus padres se casan.',
            'poster_url' => 'https://ntvb.tmsimg.com/assets/p175884_v_h10_aa.jpg?w=960&h=540',
            'video_url' => 'https://www.youtube.com/watch?v=CewJ-ihfNMQ',
            'duration_minutes' => 98,
            'genre' => 'Comedia',
        ]);

        Peliculas::create([
            'title' => 'Zombieland',
            'description' => 'Un tímido estudiante que intenta llegar a Ohio para ver si su familia ha sobrevivido se une a un pistolero que busca el último Twinkie y dos hermanas.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTU5MDg0NTQ1N15BMl5BanBnXkFtZTcwMjA4Mjg3Mg@@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=8m9EVP8X7N8',
            'duration_minutes' => 88,
            'genre' => 'Comedia, Terror',
        ]);

        // ============== CIENCIA FICCIÓN ==============
        Peliculas::create([
            'title' => 'Blade Runner 2049',
            'description' => 'Un joven blade runner descubre un secreto enterrado que podría sumir lo que queda de la sociedad en el caos y lo lleva a buscar a Rick Deckard.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNzA1Njg4NzYxOV5BMl5BanBnXkFtZTgwODk5NjU3MzI@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=gCcx85zbxz4',
            'duration_minutes' => 164,
            'genre' => 'Ciencia Ficción, Thriller',
        ]);

        Peliculas::create([
            'title' => 'Ex Machina',
            'description' => 'Un joven programador es seleccionado para participar en un experimento que evalúa las capacidades humanas de una inteligencia artificial altamente avanzada.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTUxNzc0OTIxMV5BMl5BanBnXkFtZTgwNDI3NzU2NDE@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=EoQuVnKhxaM',
            'duration_minutes' => 108,
            'genre' => 'Ciencia Ficción, Drama',
        ]);

        Peliculas::create([
            'title' => 'Edge of Tomorrow',
            'description' => 'Un soldado luchando contra alienígenas queda atrapado en un bucle temporal, reviviendo su último día en el campo de batalla una y otra vez.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTc5OTk4MTM3M15BMl5BanBnXkFtZTgwODcxNjg3MDE@._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=vw61gCe2oqI',
            'duration_minutes' => 113,
            'genre' => 'Ciencia Ficción, Acción',
        ]);

        Peliculas::create([
            'title' => 'Arrival',
            'description' => 'Una lingüista es reclutada por las fuerzas militares para comunicarse con formas de vida extraterrestres que han llegado a la Tierra.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTExMzU0ODcxNDheQTJeQWpwZ15BbWU4MDE1OTI4MzAy._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=tFMo3UJ4B4g',
            'duration_minutes' => 116,
            'genre' => 'Ciencia Ficción, Drama',
        ]);

        Peliculas::create([
            'title' => 'Tenet',
            'description' => 'Un agente de la CIA descubre una tecnología de manipulación temporal y es reclutado para prevenir el inicio de la Tercera Guerra Mundial.',
            'poster_url' => 'https://m.media-amazon.com/images/M/MV5BYzg0NGM2NjAtNmIxOC00MDJmLTg5ZmYtYzM0MTE4NWE2NzlhXkEyXkFqcGdeQXVyMTA4NjE0NjEy._V1_.jpg',
            'video_url' => 'https://www.youtube.com/watch?v=AZGcmvrTX9M',
            'duration_minutes' => 150,
            'genre' => 'Ciencia Ficción, Acción',
        ]);

        
    }
}