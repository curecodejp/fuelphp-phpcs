# PHP_CodeSniffer FuelPHP Standard

PHP Code Sniffer rules that cover a large part of the [FuelPHP coding standards](http://docs.fuelphp.com/general/coding_standards.html).

## 要件

- PHP >= 8.0
- PHP_CodeSniffer >= 3.0

## インストール

### 1. composer.json に追加

`composer.json` の `repositories` にこのパッケージのリポジトリを追加し、`require-dev` に依存関係を追加します。

```json
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/curecodejp/fuelphp-phpcs.git",
            "only": ["eviweb/fuelphp-phpcs"]
        }
    ],
    "require-dev": {
        "squizlabs/php_codesniffer": "^3.0",
        "eviweb/fuelphp-phpcs": "^2.0",
        "dealerdirect/phpcodesniffer-composer-installer": "^1.0"
    },
    "config": {
        "allow-plugins": {
            "dealerdirect/phpcodesniffer-composer-installer": true
        }
    }
}
```

### 2. インストール実行

```bash
composer update squizlabs/php_codesniffer eviweb/fuelphp-phpcs dealerdirect/phpcodesniffer-composer-installer
```

`dealerdirect/phpcodesniffer-composer-installer` が自動的に FuelPHP スタンダードを phpcs に登録します。

### 3. インストール確認

```bash
# phpcs のバージョン確認
./vendor/bin/phpcs --version
# PHP_CodeSniffer version 3.x.x ...

# FuelPHP スタンダードが登録されていることを確認
./vendor/bin/phpcs -i
# The installed coding standards are ... FuelPHP ...

# 利用可能なスニフ一覧
./vendor/bin/phpcs --standard=FuelPHP -e
```

## 使い方

### 基本的な使い方

```bash
# ディレクトリ全体をチェック
./vendor/bin/phpcs --standard=FuelPHP fuel/app/classes/

# 特定のファイルをチェック
./vendor/bin/phpcs --standard=FuelPHP fuel/app/classes/util.php
```

### プロジェクト固有の設定（phpcs.xml）

プロジェクトルートに `phpcs.xml` を作成すると、プロジェクト固有のルール除外やパス設定ができます。

```xml
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="MyProject">
    <description>MyProject coding standard based on FuelPHP</description>

    <!-- FuelPHP スタンダードをベースにする -->
    <rule ref="FuelPHP">
        <!-- 不要なルールを除外する例 -->
        <exclude name="FuelPHP.NamingConventions.ConciseUnderscoredVariableName.NotUnderscore"/>
        <exclude name="FuelPHP.NamingConventions.LowerCaseFileName.UpperCaseInFileName"/>
    </rule>

    <!-- チェック対象のディレクトリ -->
    <file>fuel/app/classes</file>
    <file>fuel/app/views</file>
    <file>fuel/app/tasks</file>

    <!-- チェック除外するディレクトリ -->
    <exclude-pattern>fuel/app/vendor/*</exclude-pattern>
    <exclude-pattern>fuel/core/*</exclude-pattern>
    <exclude-pattern>fuel/packages/*</exclude-pattern>
</ruleset>
```

`phpcs.xml` を使う場合:

```bash
# phpcs.xml を自動検出（プロジェクトルートで実行）
./vendor/bin/phpcs

# 明示的に指定
./vendor/bin/phpcs --standard=phpcs.xml fuel/app/classes/
```

### VSCode との連携

1. VSCode 拡張 `shevaua.phpcs` をインストール
2. `.vscode/settings.json` に以下を追加:

```json
{
    "phpcs.executablePath": "fuel/vendor/bin/phpcs",
    "phpcs.standard": "phpcs.xml"
}
```

> **Note**: `fuel/vendor/bin/phpcs` のパスはプロジェクトの composer の `vendor-dir` 設定に依存します。通常の FuelPHP プロジェクトでは `fuel/vendor/bin/phpcs` です。

### 自動修正（phpcbf）

一部のエラーは `phpcbf` で自動修正できます:

```bash
./vendor/bin/phpcbf --standard=FuelPHP fuel/app/classes/
```

## 含まれるスニフ一覧

### カスタムスニフ（FuelPHP 固有）

| スニフ | 説明 |
|---|---|
| `FuelPHP.Arrays.ArrayDeclaration` | 配列宣言のフォーマット（アライメント、改行等） |
| `FuelPHP.Classes.ClassDeclaration` | クラス/インターフェース宣言のフォーマット |
| `FuelPHP.Formatting.BracesOnNewLine` | 制御構造の括弧を次の行に配置（Allman スタイル） |
| `FuelPHP.NamingConventions.ConciseUnderscoredVariableName` | 変数名はアンダースコア形式、30文字以内 |
| `FuelPHP.NamingConventions.LowerCaseFileName` | ファイル名はすべて小文字 |
| `FuelPHP.NamingConventions.UnderscoredWithScopeFunctionName` | メソッド名はアンダースコア形式、可視性を明示 |
| `FuelPHP.WhiteSpace.ControlStructureSpacing` | 制御構造の括弧周りのスペース |
| `FuelPHP.WhiteSpace.DisallowSpaceIndent` | インデントはタブのみ（スペース禁止） |
| `FuelPHP.WhiteSpace.IncrementDecrementSpacing` | `++`/`--` と変数の間にスペースなし |
| `FuelPHP.WhiteSpace.NotOperatorSpacing` | `!` 演算子の前後にスペース必須 |

### 外部スニフ（phpcs 標準ルール）

Generic, PEAR, Squiz, Zend から 19 個のスニフを利用しています。
詳細は `Standards/FuelPHP/ruleset.xml` を参照してください。

## phpcs 2.x からの移行

phpcs 2.x（v1.x）から移行する場合:

1. `composer.json` の `squizlabs/php_codesniffer` を `"^3.0"` に変更
2. `eviweb/fuelphp-phpcs` を `"^2.0"` に変更
3. `dealerdirect/phpcodesniffer-composer-installer` を追加
4. `phpcs.xml` でスニフ名の短縮形を使っている場合、正式名に修正
   - 例: `UnderscoredWithScope` → `UnderscoredWithScopeFunctionName`
5. `composer update` を実行

## ライセンス

MIT License
