## ECommerce Using Laravel + MySQL, recommendation engine support using Neo4j

This Simple App demonstrates recommendations for purchases to increase purchase probability. 

Tech Stack
1. Laravel + Tailwind 
2. MySQL
3. Neo4j

   Background sync task uploads the graph to neo4j server

   ![image](https://github.com/user-attachments/assets/e2c3d5f9-845c-48da-8123-970625a51517)

   1. Migrate DB >> php artisan migrate
   2. Configure Change DB login in \App\DB\GraphConnector
