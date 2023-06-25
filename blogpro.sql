-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 23 juin 2023 à 14:52
-- Version du serveur : 8.0.33-0ubuntu0.22.04.2
-- Version de PHP : 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blogpro`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `comment`, `published`, `created_at`) VALUES
(21, 2, 32, 'Très intéressant cet article !', 1, '2023-05-05 16:32:14'),
(24, 13, 36, 'Super !', 0, '2023-05-19 16:16:19'),
(25, 14, 36, 'De bons conseils.', 1, '2023-05-19 16:18:44'),
(26, 1, 36, 'En effet !', 0, '2023-05-25 09:01:06');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` tinytext NOT NULL,
  `content` longtext NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `subtitle`, `content`, `user_id`, `created_at`) VALUES
(32, ' Introduction au développement web: Les bases essentielles pour les débutants', 'Découvrez les fondamentaux du développement web et commencez à créer vos propres sites', '<p>Le développement web est un domaine passionnant et en constante évolution qui permet de créer des sites web interactifs et fonctionnels. Dans cet article, nous allons explorer les bases essentielles du développement web pour les débutants.</p>\r\n\r\n<p>Tout d\'abord, le langage HTML (HyperText Markup Language) est la pierre angulaire du développement web. HTML permet de structurer le contenu des pages web en utilisant des balises, des éléments et des attributs. Vous apprendrez à créer des titres, des paragraphes, des listes et d\'autres éléments de base en utilisant les balises HTML appropriées.</p>\r\n\r\n<p>Ensuite, nous aborderons le CSS (Cascading Style Sheets), qui est utilisé pour styliser les pages web. Avec CSS, vous pourrez modifier l\'apparence de votre site en contrôlant les couleurs, les polices, les marges, les bordures et d\'autres propriétés de style. Vous découvrirez comment ajouter du style à vos pages web en utilisant des sélecteurs CSS pour cibler des éléments spécifiques.</p>\r\n\r\n<p>En plus de l\'HTML et du CSS, vous explorerez également le JavaScript, un langage de programmation utilisé pour ajouter de l\'interactivité aux sites web. Vous apprendrez les bases de la programmation JavaScript, y compris les variables, les fonctions et les boucles. Vous découvrirez comment manipuler le contenu de la page, gérer les événements et créer des fonctionnalités interactives.</p>\r\n\r\n<p>Nous aborderons également des concepts importants tels que la conception réactive, qui permet aux sites web de s\'adapter et de fonctionner de manière optimale sur différents appareils et tailles d\'écran. Vous découvrirez comment créer des mises en page fluides et flexibles en utilisant des techniques comme les media queries et les frameworks CSS responsives.</p>\r\n\r\n<p>Enfin, nous discuterons des outils essentiels du développement web, tels que les éditeurs de code, les navigateurs web et les outils de débogage. Vous apprendrez à utiliser ces outils pour faciliter votre processus de développement et améliorer l\'efficacité de votre travail.</p>\r\n\r\n<p>En conclusion, ce guide d\'introduction au développement web vous a familiarisé avec les bases essentielles du développement web. À partir des langages HTML, CSS et JavaScript, vous pouvez créer des sites web attrayants, interactifs et réactifs. Continuez à explorer et à pratiquer ces concepts pour développer vos compétences et votre expertise dans le domaine du développement web.</p>', 1, '2023-05-01 16:15:45'),
(33, 'Les tendances actuelles du développement web: Quoi de neuf en 2023?', ' Découvrez les dernières avancées et tendances du développement web cette année', '<p>Le développement web est un domaine en constante évolution, avec de nouvelles technologies, frameworks et tendances émergentes chaque année. Alors que nous entrons dans l\'année 2023, il est intéressant de se pencher sur les tendances actuelles du développement web et de découvrir ce qui fait sensation dans l\'industrie. Dans cet article, nous explorerons les dernières avancées et tendances du développement web en 2023.</p>\r\n\r\n<p>Une des tendances majeures cette année est l\'essor de la conception web centrée sur l\'utilisateur. Les développeurs web accordent de plus en plus d\'importance à l\'expérience utilisateur (UX) et à l\'accessibilité. Ils se concentrent sur la création de sites web intuitifs, faciles à naviguer et répondant aux besoins des utilisateurs. L\'adoption de pratiques de conception axée sur l\'utilisateur, telles que les tests utilisateurs et la recherche UX, est devenue courante pour garantir des expériences web exceptionnelles.</p>\r\n\r\n<p>Un autre domaine en plein essor est celui du développement web progressif (PWA). Les PWA sont des sites web qui offrent une expérience utilisateur similaire à celle des applications natives, avec des fonctionnalités telles que des notifications push, un accès hors ligne et une installation sur l\'écran d\'accueil. Les PWA sont de plus en plus adoptées par les entreprises car elles permettent d\'offrir une expérience utilisateur cohérente sur toutes les plateformes, tout en réduisant les coûts de développement par rapport au développement d\'applications natives distinctes.</p>\r\n\r\n<p>L\'intelligence artificielle (IA) et l\'apprentissage automatique (machine learning) jouent également un rôle croissant dans le développement web. Les développeurs utilisent des bibliothèques et des frameworks d\'IA tels que TensorFlow.js et scikit-learn pour créer des applications web intelligentes, telles que des chatbots, des systèmes de recommandation personnalisée et des assistants virtuels. L\'IA et le machine learning permettent d\'améliorer l\'efficacité des sites web en automatisant des tâches complexes et en offrant des fonctionnalités avancées.</p>\r\n\r\n<p>La sécurité web est un autre domaine crucial qui continue d\'évoluer. Avec l\'augmentation des cyberattaques, les développeurs web doivent prendre des mesures pour protéger les sites web contre les vulnérabilités et les intrusions. Les certifications HTTPS, les pare-feu de sécurité et les pratiques de codage sécurisé sont devenus des normes pour garantir la sécurité des données des utilisateurs.</p>\r\n\r\n<p>Enfin, la réalité virtuelle (VR) et la réalité augmentée (AR) font également leur entrée dans le développement web. Les développeurs utilisent des frameworks tels que A-Frame et AR.js pour créer des expériences immersives et interactives directement dans les navigateurs web. Ces technologies ouvrent de nouvelles possibilités pour les sites web de jeux, de tourisme virtuel, de visualisation de produits et bien plus encore.</p>\r\n\r\n<p>En conclusion, le développement web continue de se transformer avec de nouvelles avancées et tendances en 2023. La conception centrée sur l\'utilisateur, les PWA, l\'IA et le machine learning, la sécurité web et la réalité virtuelle/réalité augmentée sont quelques-unes des tendances majeures qui façonnent l\'industrie. Les développeurs web doivent rester à l\'affût de ces nouvelles tendances et technologies pour rester compétitifs sur le marché.</p>\r\n\r\n<p>Il est également important de noter que la rapidité et les performances des sites web sont devenues des préoccupations majeures. Les utilisateurs s\'attendent à ce que les sites se chargent rapidement et offrent une expérience fluide. C\'est pourquoi l\'optimisation des performances est devenue une priorité pour de nombreux développeurs web. L\'utilisation de techniques telles que la mise en cache, la compression des fichiers, la minimisation du code et l\'optimisation des images est essentielle pour garantir des performances optimales.</p>\r\n\r\n<p>En résumé, le développement web en 2023 est caractérisé par des tendances telles que la conception centrée sur l\'utilisateur, les PWA, l\'IA et le machine learning, la sécurité web, la réalité virtuelle/réalité augmentée, ainsi que l\'optimisation des performances. Les développeurs web doivent suivre ces tendances et acquérir de nouvelles compétences pour créer des sites web innovants et répondre aux besoins en constante évolution des utilisateurs. En restant à l\'affût des dernières avancées du développement web, vous serez prêt à relever les défis et à saisir les opportunités offertes par ce domaine passionnant.</p>', 1, '2023-04-10 16:21:03'),
(34, 'CSS pour les débutants: Stylez vos sites web avec facilité', ' Apprenez les fondamentaux de CSS pour rendre vos pages web plus attrayantes', '<p>CSS (Cascading Style Sheets) est le langage utilisé pour styliser et mettre en forme les pages web. Dans cet article, nous vous guiderons à travers les bases de CSS, en vous montrant comment ajouter des couleurs, des polices, des marges et des bordures à vos pages web.</p>\r\n\r\n<p>CSS fonctionne en associant des règles de style à des éléments HTML spécifiques. Vous pouvez définir une règle de style pour tous les titres contenus dans les balises < h1 > de votre page et spécifier la couleur, la taille de police et la marge autour de ces titres. En utilisant des sélecteurs CSS, tels que les classes ou les identifiants, vous pouvez également cibler des éléments spécifiques.</p>\r\n\r\n<p>Les propriétés CSS vous permettent de contrôler différents aspects de l\'apparence de vos pages web. Par exemple, la propriété \"color\" définit la couleur du texte, \"font-size\" contrôle la taille de la police, et \"margin\" définit les marges autour des éléments. Utilisez ces propriétés pour personnaliser l\'apparence de vos pages selon vos préférences.</p>\r\n\r\n<p>CSS offre également des fonctionnalités de mise en page flexibles et réactives. Les propriétés de flexbox et de grille vous permettent d\'organiser les éléments de votre page de manière fluide et de les ajuster automatiquement en fonction de la taille de l\'écran ou de l\'appareil utilisé pour afficher le site web.</p>\r\n\r\n<p>En plus des propriétés de base, CSS propose des transitions et des animations pour ajouter des effets visuels et dynamiques. Créez des transitions fluides entre les états d\'un élément ou animez des propriétés telles que la taille, la position et la transparence. Ces fonctionnalités ajoutent de l\'interactivité et du dynamisme à vos sites web.</p>\r\n\r\n<p>Des préprocesseurs CSS tels que Sass et Less étendent les fonctionnalités de base de CSS en ajoutant des variables, des mixins et des fonctions. Ces préprocesseurs rendent l\'écriture du code CSS plus efficace et modulaire, facilitant la gestion et la réutilisation de votre code.</p>\r\n\r\n<p>En conclusion, CSS est un outil puissant pour styliser vos pages web et leur donner une apparence attrayante. Apprenez les bases de CSS pour personnaliser l\'apparence de vos sites web, créer des mises en page flexibles et réactives, et ajouter des transitions et des animations pour une expérience utilisateur immersive. Pratiquez et explorez les fonctionnalités avancées de CSS pour maîtriser davantage ce langage essentiel du développement web.</p>', 1, '2023-03-14 16:23:15'),
(35, ' Introduction au développement web: Comprendre les bases du HTML', 'Découvrez le langage de balisage essentiel pour créer des sites web', '<p>HTML (HyperText Markup Language) est le langage de base utilisé pour structurer et présenter le contenu des pages web. Dans cet article, nous vous introduisons aux bases du HTML, vous permettant de créer des pages web simples et structurées. Le HTML est composé de balises, d\'éléments et d\'attributs, qui servent à définir la structure et le contenu d\'une page web.</p>\r\n\r\n<p>Les balises HTML sont utilisées pour entourer les éléments et définir leur fonction. Par exemple, la balise  < h1 > est utilisée pour définir un titre de niveau 1, tandis que la balise < p > est utilisée pour définir un paragraphe. Les balises peuvent également avoir des attributs qui fournissent des informations supplémentaires sur les éléments. Par exemple, l\'attribut \"src\" est utilisé pour spécifier l\'emplacement d\'une image dans la balise < img >.</p>\r\n\r\n<p>En utilisant les balises et les attributs appropriés, vous pouvez structurer votre contenu de manière logique et sémantique. Par exemple, vous pouvez utiliser la balise < header > pour l\'en-tête de votre page, la balise < nav > pour la navigation, et la balise < footer > pour le pied de page. Cela permet aux moteurs de recherche et aux lecteurs d\'écran de mieux comprendre la structure de votre page.</p>\r\n\r\n<p>Le HTML offre également des fonctionnalités pour créer des liens hypertexte, insérer des images, des vidéos et des tableaux, et bien plus encore. En utilisant différentes balises et attributs, vous pouvez ajouter des éléments interactifs et multimédias à votre site web.</p>\r\n\r\n<p>Il est important de noter que le HTML est un langage statique, ce qui signifie que les pages web créées avec HTML seul sont généralement fixes et ne peuvent pas être modifiées dynamiquement. C\'est là que le CSS (Cascading Style Sheets) et JavaScript entrent en jeu, permettant de styliser et d\'ajouter des fonctionnalités interactives aux pages web.</p>\r\n\r\n<p>En conclusion, le HTML est la base du développement web. En comprenant les bases du HTML, vous pourrez créer des pages web structurées et sémantiques. Les balises, les éléments et les attributs du HTML vous permettent de définir la structure et le contenu de votre page. Continuez à explorer le HTML et associez-le au CSS et au JavaScript pour créer des sites web plus avancés et interactifs.</p>', 1, '2023-02-15 16:26:07'),
(36, 'Les étapes du développement web pour les débutants', 'Découvrez le processus de création d\'un site web, de la conception à la mise en ligne', '<p>Le développement web implique un processus itératif et bien défini pour créer un site web fonctionnel et attrayant. Dans cet article, nous allons vous présenter les étapes clés du développement web, idéales pour les débutants qui souhaitent se lancer dans cette discipline passionnante.</p>\r\n<p>Planification: La première étape consiste à définir les objectifs de votre site web et à planifier sa structure et son contenu. Réfléchissez à votre public cible, à vos besoins en matière de fonctionnalités et à l\'apparence générale que vous souhaitez donner à votre site.</p>\r\n<p>Conception: Une fois que vous avez une idée claire de votre projet, il est temps de passer à la conception. Créez une maquette ou un wireframe qui représente l\'organisation et la disposition de votre site. Choisissez les couleurs, les polices et les éléments visuels qui reflètent l\'identité de votre marque.</p>\r\n<p>Développement frontend: Cette étape implique la traduction de la conception en code. Utilisez HTML, CSS et JavaScript pour créer la structure, le style et les fonctionnalités de votre site web. Assurez-vous que votre site est compatible avec les différents navigateurs et appareils en pratiquant des techniques de développement réactif.</p>\r\n<p>Développement backend: Si votre site nécessite des fonctionnalités avancées, comme l\'interaction avec une base de données ou l\'authentification des utilisateurs, vous devrez développer une partie backend. Choisissez un langage de programmation adapté, comme PHP, Python ou Ruby, et utilisez un framework pour accélérer le processus de développement.</p>\r\n<p>Tests et débogage: Il est essentiel de tester votre site web à toutes les étapes du développement. Vérifiez la fonctionnalité, la compatibilité, la vitesse de chargement et la convivialité. Effectuez des tests croisés sur différents navigateurs et appareils pour vous assurer que votre site fonctionne correctement partout.</p>\r\n<p>Mise en ligne: Une fois que votre site est prêt, il est temps de le mettre en ligne. Choisissez un hébergeur web et configurez votre nom de domaine. Assurez-vous que votre site est sécurisé en installant un certificat SSL et en mettant en place des mesures de sécurité appropriées.</p>\r\n<p>Maintenance continue: Le développement web est un processus continu. Assurez-vous de mettre à jour régulièrement votre site web, d\'ajouter de nouvelles fonctionnalités et de résoudre les éventuels problèmes qui surviennent. Gardez votre site sécurisé en appliquant les mises à jour de sécurité et en effectuant des sauvegardes régulières.</p>\r\n<p>En conclusion, le développement web suit un processus bien défini, de la planification à la maintenance continue. En comprenant les étapes clés du développement web, vous serez en mesure de créer et de maintenir des sites web fonctionnels et attrayants. Continuez à pratiquer et à acquérir de l\'expérience pour améliorer vos compétences en développement web.</p>', 1, '2023-05-19 16:42:38');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','registered') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'David', 'mail@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin'),
(2, 'Olivier', 'testmail@mail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'registered'),
(4, 'Lucie', 'test2@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'registered'),
(13, 'Jean', 'test@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'registered'),
(14, 'Michel', 'michel@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'registered');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE RESTRICT,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
