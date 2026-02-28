 Guide d'Utilisation - Système de Retards

Rappel de récupération (J+5)

Condition : date_today = date_disponible + 5 ET date_recuperation = null
Message uniquement à l'enseignant
Type notification : recuperation


Avertissement de remise (J+10)

Condition : date_today = date_disponible + 10 ET date_remise = null
Message uniquement à l'enseignant
Type notification : avertissement_remise


Retard confirmé (J+14+)

Condition : date_today > date_disponible + 14 ET date_remise = null
Messages à l'enseignant ET au DA
Type notification : retard_remise