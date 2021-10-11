
# Articles
Pour les articles on peut préciser le nombre d'argument(nbr) et la page(page) via les données get
### **GET**
    "/api/article" : Retourne tout les articles
    "/api/article/{token}" : Retourne les informations d'un article à l'aide de sont token
    "/api/article/website/{websiteToken}" : Retourne tout les articles d'un site web
    "/api/article/category/{categoryToken}" : Retourne tout les articles d'une categorie
    "/api/article/search?str={str}" : permet de chercher un article à l'aide d'un mot clé dans son titre ou son contenu

### **DELETE**
    "/api/article/{token}" : Suprimme un article à l'aide de son token

### **PUT**
    "/api/article/{token}" : Met à jour un article à l'aide de sont token
        Content-Type: application/json

        {
            "token": "",
            "title": ""(min:2),
            "pageLink": ""(lien valide),
            "imageLink": ""(lien valide),
            "contentBase": "",
            "date": ""(date valide),
            "categorieToken": ""(categorie existante),
            "webSiteToken": ""(site web existant)
        }

# Websites:
### **GET** 
    "/api/website" : retourne tout les sites web
    "/apit/website/{token}" : retourne les informations d'un site web à l'aide de son token

### **POST**
    "/api/website" : permet d'ajouter un site web
        Content-Type: application/json
        
        {
            "name" : ""(min:2),
            "indexPageLink" : ""(site web obligatoire)
        }

### **PUT**
    "/api/website/{token} : permet de mettre à jour un site web à l'aide de son token
        Content-Type: application/json

        {
            "token" : ""(token non utilisé),
            "name" : ""(min:2),
            "indexPageLink" : ""(site web obligatoire)
        }

### **DELETE**
    "/api/website/{token}" : permet de suprimer un site web à l'aide de son token
# Categories:
### **GET** 
    "/api/category" : retourne toutes les categories
    "/apit/category/{token}" : retourne les informations d'une categorie à l'aide de son token

### **POST**
    "/api/category" : permet d'ajouter une categorie
        Content-Type: application/json
        
        {
            "name" : ""(min:2)
        }

### **PUT**
    "/api/category/{token} : permet de mettre à jour une categorie à l'aide de son token
        Content-Type: application/json

        {
            "name" : ""(min:2)
        }

### **DELETE**
    "/api/category/{token}" : permet de suprimer une categorie à l'aide de son token

