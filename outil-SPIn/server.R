#           Projet : Outil-SPIn
#           Auteur : BLE
# Date de création : 16/12/19
#            Objet : Server-side de l’outil de suivi des projets


# Chargement des bibliothèques
library(shiny)

# Chargement des données
taches <- read.csv2("../tache.csv")

shinyServer(function(input, output) {
   
  # chargement des données
  output$dt <- DT::renderDataTable(taches, editable = T);
})
