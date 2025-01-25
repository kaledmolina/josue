<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Videos extends Component
{
    public $videos = [
        [
            'title' => 'La Quiteña Bonita',
            'url' => 'https://www.youtube.com/embed/v8tMU-wpcH0',
            'description' => 'Hace unos meses emprendí este proyecto en Moñitos, Córdoba, un lugar mágico donde el 
            sonido de las olas y la calidez de su gente cuentan historias propias. La Quiteña Bonita
            no es solo un espacio para descansar, es un refugio para reconectar con la naturaleza y el alma.

            Durante la grabación, me dediqué a capturar cada detalle: los amaneceres dorados sobre la playa, 
            la sencillez de las cabañas y el espíritu único de la costa. Este comercial fue un reto que me permitió
            resaltar la esencia de lo simple y hermoso.

            Fue una experiencia que mezcló técnicas de cinematografía natural con tomas aéreas que logran transportarte 
            al paraíso. Si alguna vez buscas desconectarte del caos, La Quiteña Bonita es ese rincón especial que
            estás esperando.',
            'alignment' => 'left'
        ],
        [
            'title' => 'Liga Contra el Cáncer',
            'url' => 'https://www.youtube.com/embed/JqWy4-4gml0',
            'description' => 'Este proyecto fue una ventana al pasado, un recorrido por la historia de una institución
            que ha sido pilar en la lucha contra el cáncer en Córdoba. Durante la producción, nos 
            sumergimos en archivos, historias y testimonios de personas que han encontrado en la 
            Liga no solo apoyo médico, sino también un faro de esperanza.

            Con tomas que combinan entrevistas emotivas y recreaciones visuales, quisimos mostrar cómo 
            esta organización ha evolucionado desde sus primeros pasos hasta convertirse en un símbolo de 
            solidaridad para la comunidad cordobesa. Este trabajo no solo fue audiovisual, fue un tributo
            a quienes, con esfuerzo y corazón, han salvado vidas y han sembrado esperanza.

            La reseña no solo cuenta una historia, también invita a todos a ser parte de ella, a unir fuerzas 
            para seguir transformando vidas.'
            ,
            'alignment' => 'right'
        ]
    ];
    public function render()
    {
        return view('livewire.videos');
    }
}
