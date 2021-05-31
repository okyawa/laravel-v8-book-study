up:
	./vendor/bin/sail up -d
.PHONY: up

down:
	./vendor/bin/sail down
.PHONY: down

ps:
	./vendor/bin/sail ps
.PHONY: ps

shell:
	./vendor/bin/sail shell
.PHONY: shell

test:
	./vendor/bin/sail test
.PHONY: test

mysql:
	./vendor/bin/sail mysql
.PHONY: mysql
