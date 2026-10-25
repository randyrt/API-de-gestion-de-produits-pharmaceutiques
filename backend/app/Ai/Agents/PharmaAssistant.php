<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;
use Stringable;
use App\Ai\Tools\SearchProducts;
use App\Models\User;


class PharmaAssistant implements Agent, Conversational, HasTools
{
    use Promptable;

    public function __construct(
        private User $user
    ) {
    }

    /**
     * Instructions données à l'assistant IA.
     */
    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
Tu es PharmaAssistant, un assistant spécialisé dans la
gestion des produits pharmaceutiques.

Réponds toujours en français, de manière claire et concise.

Pour toute question portant sur les produits, les prix ou
les stocks, utilise l'outil SearchProducts lorsque cela
est pertinent.

Base tes réponses sur les résultats réellement retournés
par l'outil. N'invente jamais de produits, de prix ou de
quantités.

Si aucun résultat n'est trouvé, indique-le clairement.
Ne modifie jamais les données de la base de données.
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
        return [
            new SearchProducts($this->user),
        ];
    }
}
