# TennisTournament
Code challenge

![image](https://github.com/raulcori/TennisTournament/assets/19628688/aa3234f6-bdcc-431e-88b5-8c05accbfca2)


## Instalación
1. Actualizar dependencias y autoload

``composer update``

``composer dump-autoload``

2. Importar DB desde el archivo: ``db_schema/tennis_tournament.sql``

3. Crear un archivo ``.env`` usando ``.env.example`` como ejemplo.


## Testing
Correr el siguiente comando para realizar los tests unitarios

``./vendor/bin/phpunit --testdox tests``


## Stack:
* PHP 8.2
* MariaDB 10.4.32-MariaDB
* Apache/2.4.58


## Estilo de código: 
* PHP sin frameworks, pero con librerías de composer: phpunit, autoload, phpdotenv
* POO, tipos estrictos, estandar PSR-12.
* Patrones Ej: ValueObject, Builders
* Excepciones de dominio personalizadas
* Herencia, Interfaces, Inyección de dependencias, Responsabilidad única, etc.


## Implementación y Alcance:

Se considera una cantidad de jugadores por torneo no necesariamente potencia entera de 2.
 
Se desarrollaron dos casos de uso: simular el torneo (y guardar el ganador) y buscar ganadores.
 
Manejo de errores básico.
 
Front controller. Se creó un archivo ``.htaccess`` en la raíz para modificar las reglas del apache.
	
Se realizaron algunos test unitarios.
 
Conexión a 1 base de datos (MySQL/MariaDB). Pero switcheable a otras formas de persistencia desde el archivo .env
	
Control de los metodos HTTP y urls. No se controla ni valida el cliente.
	
Lo realizado considero personalmente suficiente como demostracion aunque se pudieron mejorar e incluir varias cosas más.
	
	
## Algunas mejoras
* Agregar middlewares para: Validar clientes y tokens, Loggear de request y responses.
* Usar caches
* Poner otro medio de persistencia
* Guardar los resultados de todos los matches del torneo. 
* Contar los partidos jugados de cada players para poder seleccionar jugadores que tengan menos partidas jugadas.
	

## Arquitectura: 
Hexagonal ordenada en primer nivel por entidad, nombre de la capa en segundo nivel.	

```
├── game/
│   ├── application/
│   ├── domain/
│   └── infrastructure/
├── player/
│   ├── application/
│   ├── domain/
│   └── infrastructure/
├── tournament/
│   ├── application/
│   ├── domain/
│   └── infrastructure/
└── util/
    ├── application/
    ├── domain/
    └── infrastructure/
```

En la carpeta util se puso tanto los utilitarios como la lógica compartida por las entidades.
	
## Conocimiento funcional: El caso más relevante es el de ``jugar torneo``.
1. Se reciven y validan los datos del torneo y sus jugadores.
2. Se randomiza el orden de los jugadores.
3. Se arman las parejas pudiendo quedar un jugador sin pareja, si en la primera ronda el número de jugadores es impar.
3. Se juga la primera ronda el mismo día de inicio del torneo, las demás rondas de juegan 7 días después de la ronda anterior, así hasta llegar a la final.
4. Se determina el ganador de cada match. 
5. Con los ganadores de la ronda se vuelve al paso 2. Hasta que exista un sólo match, el ganador de la última ronda es el ganador del torneo.
6. Se guarda el resultado fianl del torneo.
	
### Determinación del ganador
1. Se calcula un valor de performance para ambos, el mayor gana : 
2. El factor de suerte solo puede afectar hasta -50%  +50% al valor original.
3. Performance: ``$OriginalPerformance * (1 + $luckFactor->value() * ($random - 0.5) / 100);``

``$luckFactor`` puede valor entre 0 y 100
``$random`` es un numero flotante en el intervalo [0;1)
	
### OriginalPerformance:
* Hombres: ``$performance = $player->level->value() * $player->force * $player->displacementSpeed;``
* Mujeres: ``$player->reactionTime != 0 ? $player->level->value() / $player->reactionTime : $player->level->value() * 1000;``




