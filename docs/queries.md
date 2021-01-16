# Queries
As queries são o modo de busca de nossa API, com ela você poderá buscar um ou todos os sobreviventes, seus itens e quantidades.

## Survivor
O survivor ( sobrevivente ) é o objeto  principal de nossa API, por ele são controlados os outros três objetos ( Item, Inventário e Denûncias )

### Busca
##### Por id
```graphql
Query {
   survivor(id: Int!) {
      id,
      name,
      birth,
      gender,
      latitude,
      longitude,
      infected,
      inventory {
         items{
            name,
            points
         }
         qty
      }
   }
}
```
##### Geral
```graphql
 Query {
       survivors() {
          id,
          name,
          birth,
          gender,
          latitude,
          longitude,
          infected,
          inventory {
             items{
                name,
                points
             }
             qty
          }
       }
    }
```
   