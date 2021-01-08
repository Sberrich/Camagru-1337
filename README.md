# Camagru-1337
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/index.png?row=true)
Projet réalisé dans le cadre de notre formation à l'école 1337 - premier projet de la branche Web
Objectifs: Gestion utilisateurs - Gestion permissions - Mailing - Sécurité / Validation de données
Compétences: Security - Web - DB & Data

# Technologies utilisées
* Serveur: PHP
* Client: Javascript
* Base de données: MySQL

# Partie Utilisateur
* L’application doit permettre à un utilisateur de s’inscrire avec:

* adresse email
* login
* username
* mot de passe
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/register.png?raw=true)

* ⚠️ Une fois l’inscription validée, un e-mail de confirmation comportant un lien unique sera envoyé sur l’adresse e-mail renseignée.
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/Screen%20Shot%202021-01-08%20at%209.48.43%20AM.png?raw=true)

* L’utilisateur doit être capable de se connecter avec:
* login
* mot de passe
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/login.png?raw=true)

* Il doit également pouvoir recevoir un mail de réinitialisation de son mot de passe en cas d’oublie.
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/recover.png?raw=true)

* L’utilisateur doit pouvoir se déconnecter en un seul clic depuis n’importe quelle page du site.

* L’utilisateur doit pouvoir Modifier son adresse email, son mot de passe et ses informations
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/edit.png?row=true)

# partie galerie
*  galerie devra être publique, donc accessible sans authentification. Elle doit afficher l’intégralité des images prises par les membres du site,
  triées par date de création. Elle doit pouvoir permettre à l’utilisateur de lescomenter et de les liker si celui-ci est authentifié.Lorsque une image reçoit un nouveau commentaire, l’auteur de cette image doit en être informé par mail.
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/Screen%20Shot%202021-01-08%20at%209.33.24%20AM.png?row=true)
⚠️Cette préférence est activée par défaut, mais peut être désactivée dans les préférences de l’utilisateur.

*  la liste des images doit être paginée, avec au moins 5 éléments par page

# Partie Montage 
⚠️Cette partie ne doit être accessible qu’aux utilisateurs connectés, et rejeter poliment l’internaute dans le cas contraire.

Cette page devra être composée de deux sections :

Une section principale, contenant l’apercu de votre webcam, la liste des images superposables disponibles et un bouton permettant de prendre la photo.

Une section latérale, affichant les miniatures de toutes les photos prises précedemment.

![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/Screen%20Shot%202021-01-08%20at%209.32.42%20AM.png?row=true)

Les images superposables doivent être sélectionnables, et le bouton permettant de prendre la photo ne doit pas être cliquable tant qu’aucune image n’est sélectionnée.

ℹ️Le traitement de l’image finale (donc entre autres la superposition des deux images) doit être fait coté serveur, en PHP.

Parce que tout le monde n’a pas de webcam, vous devez laisser la possibilité d’uploader une image au lieu de la prendre depuis la caméra.

L’utilisateur doit pouvoir supprimer ses montages, et ⚠️uniquement les siens.
![alt text](https://github.com/Sberrich/Camagru-1337-/blob/main/captures/Screen%20Shot%202021-01-08%20at%209.33.08%20AM.png?row=true)



