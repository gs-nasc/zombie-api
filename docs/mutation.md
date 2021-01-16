# Mutations
Os mutations são o modo de alteração de nossa API, com ele você poderá alterar a localização um sobreviventes, fazer trocas e buscar relatórios.

Obs. Todos os relatórios são com valores aproximados e arredondados para melhor visulização.

## Sobrevivente

### Criar sobrevivente
```graphql
    mutation{
	  addSurvivor(
	  name: String!, 
	  birth: String! Fmt(YYYY-MM-DD), 
	  gender: String! ('M', 'F'), 
	  latitude: String!, 
	  longitude: String!, 
	  infected: int!, 
	  water: int!, 
	  food: int!, 
	  drug: int!, 
	  munition: int!
	  ){
	    id
	    name
	    birth
	    gender
	    latitude
	    longitude
	    infected
	    inventory{
	      items{
		name
	      }
	      qty
	    }
	  }
	}
```
### Atualizar localiação
```graphql
    mutation{
	  updateSurvivorLocation(
	  id: int!, 
	  latitude: String, 
	  longitude: String
	  ){
	    id
	  }
	}
```
### Fazer negociação
```graphql
    mutation{
	  tradeItem(
	  trader_id: int!, 
	  customer_id: int!, 
	  trader_item_id: int!, 
	  trader_item_qty: int!, 
	  customer_item_id: int!, 
	  customer_item_qty: int!
	  ){
	    id
	    item_id
	    qty
	    items{
	       name
	    }
	  }
	}
```
###  Reportar infecção de sobrevivente
```graphql
    mutation{
	  reportSurvivor(
	  survivor_id: int!
	  ){
	    id
	    survivor_id
	  }
	}
```
##  Relatórios

###  Porcentagem  de infectados
```graphql
    mutation{
	  infectedPercent{
	    value
	  }
	}
```
### Porcentagem de saudáveis
```graphql
    mutation{
	  noInfectedPercent{
	    value
	  }
	}
```
### Média de itens por usuário
```graphql
    mutation{
	  mediaOfItems{
	    value
	  }
	}
```
### Pontos perdidos por sobreviventes infectados
```graphql
    mutation{
	  lostPoints{
	    value
	  }
	}
```
