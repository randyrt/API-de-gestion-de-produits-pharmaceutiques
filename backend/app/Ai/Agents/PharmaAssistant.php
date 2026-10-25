<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class PharmaAssistant implements Agent, Conversational, HasTools
{
    use Promptable;

    /**
     * Instructions données à l'assistant IA.
     */
    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
Tu es PharmaAssistant, un assistant IA intégré à une
application de gestion de produits pharmaceutiques.

Tu réponds en français, de manière claire et concise.
Tu aides à comprendre la gestion des produits, les prix
et les niveaux de stock.

Tu ne dois jamais inventer les données de stock de
l'application si elles ne t'ont pas été communiquées.

Pour les questions médicales, tu fournis uniquement
des informations générales et prudentes. Tu ne remplaces
pas l'avis d'un professionnel de santé.
PROMPT;
    }

    /**
     * Messages de conversation.
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Outils disponibles pour l'agent.
     */
    public function tools(): iterable
    {
        return [];
    }
}
