# パス指定の初期値
path=

# PHPUnit でユニットテストを実行
#
# 全てのユニットテスト実行
# $ make test
# ファイルのパスを指定してユニットテストを実行する例
# $ make test path=tests/Unit/CalculatePointServiceTest.php
test:
ifdef path
	./vendor/bin/phpunit ${path}
endif
ifndef path
	./vendor/bin/phpunit ./tests/
endif
.PHONY: test

# Unitのユニットテストを実行
test-unit:
	php artisan test --group=unit
.PHONY: test-unit

# Featureのユニットテストを実行
test-feature:
	php artisan test --group=feature
.PHONY: test-feature


#
# Docker用のコマンド
#

# docker-composeの起動
up:
	./vendor/bin/sail up -d
.PHONY: up

# docker-composeの停止
down:
	./vendor/bin/sail down
.PHONY: down

# docker-compose logs の実行
ps:
	./vendor/bin/sail ps
.PHONY: ps

# dockerコンテナ内のシェルに入る
shell:
	./vendor/bin/sail shell
.PHONY: shell

# sailのシェルにrootで入る
root-shell:
	./vendor/bin/sail root-shell
.PHONY: root-shell

# コンテナ外からsailでテストを実行
sail-test:
	./vendor/bin/sail test
.PHONY: test

# mysqlに入る
mysql:
	./vendor/bin/sail mysql
.PHONY: mysql

# 使っていないDockerイメージを削除
prune:
	docker image prune
.PHONY: prune

# docker-composeで使用したコンテナのイメージを全て削除
flash:
	docker compose down --rmi all --volumes --remove-orphans
.PHONY: flash
