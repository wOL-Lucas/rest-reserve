Alunos: Lucas Eduardo, Bruno Polaski e Douglas Liebl

# Rest-reserve

<div>
  <img height="65px" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" alt="laravel icon"/>        
  <img height="65px" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vuejs/vuejs-original.svg" alt="vue icon"/>
  <img height="65px" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/rabbitmq/rabbitmq-original.svg" alt="rabbitmq icon"/>
  <img height="65px" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/postgresql/postgresql-original.svg" alt="postgres icon"/>
  <img height="65px" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/amazonwebservices/amazonwebservices-original-wordmark.svg" alt="aws icon"/>
  <img height="65px" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/docker/docker-original-wordmark.svg" alt="docker icon"/>
</div>

### Uma rede social de restaurantes.
Descubra uma nova forma de explorar os melhores restaurantes com nossa rede social dedicada à gastronomia! Encontre estabelecimentos incríveis pela sua localização, visualize cardápios atualizados, faça reservas com facilidade e fique por dentro das promoções exclusivas. Além disso, confira as avaliações e experiências de outros clientes para escolher o lugar perfeito para cada ocasião. Conecte-se com a culinária local de maneira prática e interativa!


#### Para rodar o projeto
O projeto consiste em uma arquitetura de microsserviços que, consequentemente, necessita de um container para cada serviço + gateway.
Tendo isso em vista, será necessário ter o Docker instalado na sua máquina e também o NPM (visto que o front-end foi feito em VueJS).

A primeira coisa a ser feita é rodar o comando `docker compose up` para fazer build + rodar os containeres e, depois, entrar na pasta front-end e rodar `npm install` sucedido por `npm run dev`.
Depois, é necessário cadastrar um usuário e, então, logar.
