#           Projet : Outil-SPIn
#           Auteur : BLE
# Date de création : 16/12/19
#            Objet : Interface de l’outil de suivi des projets

library(shiny)

shinyUI(fluidPage(
  
  # Application title
  titlePanel("Spindle | Spinal"),
  
  # tableau de donnees
  fluidRow(
    column(width = 12, DT::dataTableOutput("dt"))
  )
))
