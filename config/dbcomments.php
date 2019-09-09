<?php

/*
   |--------------------------------------------------------------------------
   | Commentaires des champs de la base de données
   |--------------------------------------------------------------------------
   */
return [

    //Table users
    'name' => 'Nom',
    'surname'=> 'Prénom',
    'email'=> 'Email',
    'birthday'=> 'Date de naissance',
    'photo'=> 'Photo de profil',
    'license'=> 'Numéro du permis de conduire',
    'license_type'=> 'Type de permis de conduire',
    'license_date'=> 'Date d\'établissement du permis',
    'license_date_end'=> 'Date d\'expiration du permis',
    'license_place'=> 'Lieu d\'établissement du permis',
    'birth_place'=> 'Lieu de naissance',
    'address'=> 'Adresse',
    'postal_code'=> 'Code postal',
    'tel'=> 'Téléphone',
    'town'=> 'Ville',
    'country'=> 'pays',
    'about'=> 'À propos',
    'payment_account_owner'=> 'Numéro de compte bancaire',
    'iban_nbr'=> 'Numéro IBAN (International bank account number)',
    'nbr_rental'=> 'Nombre de locations',

    'nbr_car_rental'=> 'Nombre de locations de voitures en tant que propriétaire',
    'nbr_car_rental_self'=> 'Nombre de locations de voitures en tant que locataire',
    'nbr_driver_rental_self'=> 'Nombre de locations de chauffeurs en tant que locataire',

    //Table car_brands
    'brand'=>'Marque de la voiture',

    //Table car_categories
    'category'=>'Catégorie de la voiture. Nous avons:
                  1)Citadine,
                  2)Berline,
                  3)Familliale,
                  4)Utilitaire,
                  5)Minibus,
                  6)4x4
                  7)Cabriolet,
                  8)Coupé,
                  9)Collection,
                  10)Van aménagé,
                  11)N/A (catégorie inconnue)',

    //Table car_features
    'icon'=>'L\'icône de la caractérisque de voiture',
    'feature'=>'Libellé caractéristique de voiture',

    //Table car_types
    'model'=>'Le libellé du modèle de voiture',

    //Table cars
    'alias'=>'L\'aliasse de façon unique de la voiture sur obtenue à partie de la concatenation [marque-modèle-id]',
    'address_station'=>'La localisation géographique',
    'contact'=>'Contact pour la location',
    'price_day'=>'Prix Journalier fixé au départ par le propriétaire/Chauffeur',
    'validated'=>'1 si validé par l\'administration 0 sinon',
    'availability'=>'1 si disponible 0 sinon',
    'direct_location'=>
        'Indique si la voitures est de réservation instantannée ou manuelle. 
             - 1 si réservation instantannée,
             - 0 si réservation manuelle',

    //Table car_images
    'type_images'=>
        'Le type de l\'image. 
           1)"foward" pour l\'image mise en avant,
           2)"imageLatD" pour l\'image latérale droite,
           3)"imageLatG" pour l\'image latérale gauche,
           4)"imageArrière" pour l\'image arrière,
           5)"imageInterieur" pour l\'image intérieure,
           6)"license_image" pour image du permis,
           7)"identity_image" pour image de la pièce d\'identité,
           8)"elec_image1" pour image du bulletin n°3 (casier judiciaire)',


    //Table selects
    'subject'=>'
        Détermine ce que l\'utilisateur désire louer. 
            1) "car" si voiture 
            2) "driver" si chauffeur 
            3) "car_driver" si les deux',
    'type'=>
        'Détermine si la location des directe ou indirecte. 
            1) "1" si directe, 
            2) "0" si indirecte 
            3) (null) si la sélection ne concerne que le chauffeur',

    'status'=>
        'Détermine l\'état de la demande/location. 
      
            1)"NA" si "non acceptée" (en attente), 
            2)"A" si demande acceptée, 
            3)"AN" si demande annulée par le locataire, 
            4)"E" pour location expirée cad quand le locataire a trouvé une autre voiture, 
            5)"ANA-T" pour location annulée automatiquement cad quand le locataire n\'a pas payé avant le début de la location, 
            6)"ANA-O" pour location annulée automatiquement cad quand la voiture et/ou le chauffeur ne sont plus disponibles aux dates sélectionnées,
            7)"AN-O" pour location annulée par le propriétaire,
            8)"AN-T" pour location annulée par le locataire,
            9)"AN-D" pour location annulée par le chauffeur,
            10)"N" pour location normale cad qui n\'a pas fait l\'objet d\'une annulation
            11)"D" pour déclinée',


    //Table rentals
    'timing'=>
        'Indique la périodicité d\'une location:
            1) "ongoing" pour location en cours,
            2) "upcoming" pour location à venir,
            3) "closed" pour location terminée',

    //Table car_steps
    'step'=>
        'indique l\'étape franchie lors de l\'ajout d\'un véhicule:
            - 1 pour les informations de base,
            - 2 pour les informations de la location,
            - 3 pour les disponibilités,
            - 4 pour les photos,
            - 5 pour la validation des informations saisies ()'


];