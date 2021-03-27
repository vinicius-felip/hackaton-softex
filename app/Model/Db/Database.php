<?php

namespace App\Model\Db;

use PDO;
use PDOException;
use PDOStatement;

class DataBase
{
    /**
     * Tabela que vai ser manipulada
     * 
     * @var string
     */
    private $tabela;

    /**
     * Cria a conexão com o banco de dados
     *
     * @var PDO
     */
    private $conexao;

    /**
     * Define a tabela e conexão
     *
     * @param  string $t
     * @return void
     */
    public function __construct($t = null)
    {
        $this->tabela = $t;
        $this->setConexao();
    }

    /**
     * Metodo que cria a conexão com o banco de dados
     *
     * @return void
     */
    private function setConexao()
    {
        try {
            $this->conexao = new PDO(
                "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASS')
            );
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERRO' . $e->getMessage());
        }
    }

    /**
     * Metodo que insere os dados no banco
     *
     * @param  string $query
     * @param  array $params
     * @return PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {
            $result = $this->conexao->prepare($query);
            $result->execute($params);
            return $result;
        } catch (PDOException $e) {
            die('ERRO' . $e->getCode());
        }
    }

    /**
     * Método que insere dados no banco de dados
     * 
     * @param array $info
     * @return integer
     */
    public function insert($info)
    {
        /**
         * Dados da query
         */
        $campos = array_keys($info);
        $valores = array_pad([], count($campos), '?');

        /**
         * Monta a query
         */
        $query = 'INSERT INTO ' . $this->tabela . ' (' . implode(',', $campos) . ') VALUES (' . implode(',', $valores) . ')';


        $this->execute($query, array_values($info));
        return $this->conexao->lastInsertId();
    }

    /**
     * Método que retornar dados do banco de dados
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $campos = '*', $innerJoin = null)
    {
        /**
         * Dados da query
         */
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';
        $innerJoin = strlen($innerJoin) ? 'INNER JOIN ' . $innerJoin : '';

        /**
         * Monta a query
         */
        $query = 'SELECT ' . $campos . ' FROM ' . $this->tabela . ' ' . $innerJoin . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

    /**
     * Método que atualiza dados do banco de dados
     *
     * @param  array $alterar
     * @param  string $where
     * @return boolean
     */
    public function update($alterar, $where)
    {
        /**
         * Dados da query
         */

        $campos = array_keys($alterar);

        /**
         * Monta a query
         */
        $query = 'UPDATE ' . $this->tabela . ' SET ' . implode(" = ?, ", $campos) . ' = ? WHERE ' . $this->tabela . '.' . $where;

        $this->execute($query, array_values($alterar));
        return true;
    }

    /**
     * Método que deleta uma linha do banco de dados
     *
     * @param  string $where
     * @return boolean
     */
    public function delete($where)
    {
        /**
         * Monta da query
         */
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE ' . $where;  
        
        $this->execute($query);
        return true;
    }
}
