Placez ici les 3 fichiers fournis par MobiliTech :

- employes.csv       (id, nom, email, entreprise, ville_residence, role)
- trajets.csv        (id, conducteur_id, ville_depart, ville_arrivee, horaire, places_disponibles, jours_recurrence)
- reservations.csv   (id, trajet_id, passager_id, statut, date_reservation)

Note : dans trajets.csv, la colonne jours_recurrence doit utiliser le
separateur "|" (ex: "lundi|mercredi|vendredi") pour etre lue par TrajetSeeder.

Si ces fichiers sont absents, les seeders se replient automatiquement sur les
Factories Laravel (donnees generees aleatoirement).
