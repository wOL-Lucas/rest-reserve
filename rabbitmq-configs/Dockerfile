FROM rabbitmq:3.13-management

COPY rabbitmq-configs/rabbitmq.conf /etc/rabbitmq
COPY rabbitmq-configs/definitions.json /etc/rabbitmq

RUN cat /etc/rabbitmq/rabbitmq.conf