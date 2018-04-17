
-- Structure de la table `produits`
-- 

CREATE TABLE `produits` (
  `id` bigint(20) unsigned NOT NULL,
  `quantite` int(4) NOT NULL default '0',
  `name` varchar(20) character set utf8 NOT NULL,
  `prix` float(5,2) NOT NULL,
  
  
  PRIMARY KEY  (`id`)
)
