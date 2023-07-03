<?php

namespace App\Command;

use App\Entity\News;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'create-news',
    description: 'Creates a new news.',
    aliases: ['app:add-news'],
    hidden: false,
)]
class CreateNewsCommand extends Command
{
    protected static $defaultDescription = 'Creates a new news.';

    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->entityManager = $entityManager;


        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'The title of the news.')
            ->addArgument('imgUrl', InputArgument::REQUIRED, 'The image url of the news.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output, ): int
    {

        $em = $this->entityManager;

        $title = $input->getArgument('title');
        $imgUrl = $input->getArgument('imgUrl');


        $output->writeln([
            'News Creator',
            '============',
            '',
        ]);

        $output->writeln('Title: '.$title);
        $output->writeln('Image URL: '.$imgUrl);

        $news = new News();
        $news->setTitle($title);
        $news->setImgUrl($imgUrl);
        $news->setText($this->getRandomParagraph().$this->getRandomParagraph().$this->getRandomParagraph().$this->getRandomParagraph());

        $em->persist($news);
        $em->flush();

        $output->writeln('News successfully created!');

        return Command::SUCCESS;
    }


    protected function getRandomParagraph(){
        $paragraphs = [
            "<p>Lorem ipsum dolor sit amet consectetur adipiscing elit donec tristique curae, interdum etiam quis hac sapien commodo malesuada ultrices sagittis gravida litora, lacinia hendrerit mauris sociosqu fames conubia volutpat id erat. Tempor ultrices cum nibh dui nisl inceptos placerat nullam pharetra velit, laoreet et curabitur himenaeos varius suscipit elementum scelerisque aliquet. Dis at justo senectus laoreet aenean est consequat facilisis, curabitur pharetra et nisi nibh diam curae porttitor, nisl elementum blandit mus natoque mollis fusce. Sociosqu erat aptent a vulputate enim semper luctus tempor urna, bibendum in pellentesque turpis nisl iaculis mollis litora, integer varius euismod nullam lobortis etiam ridiculus dignissim. Vehicula fusce duis iaculis dictum erat risus eros quam sociosqu nam vivamus, nulla scelerisque tortor aenean fermentum ligula posuere vel per.</p> ",
            " <p>Ad vestibulum risus sed penatibus ultrices ut pulvinar a enim interdum sapien est nostra, scelerisque egestas velit curabitur leo mauris convallis aliquet diam fringilla urna quisque. Ullamcorper class netus dui litora iaculis condimentum purus dapibus nullam, bibendum parturient odio sociosqu massa ultrices tristique. Per hendrerit aliquam a facilisis et auctor mi nisi lacinia, purus nibh class massa neque sed curabitur enim, nam diam luctus metus nullam tellus nostra ac.</p> ",
            " <p>Fermentum nec neque gravida quam habitant quis hac non parturient, mauris etiam nostra nunc placerat faucibus magnis auctor lacinia risus, nisl sociosqu accumsan vulputate dui augue malesuada aliquam. Fames habitant mus nostra natoque ac a nulla eget, donec nisl aliquam curabitur curae tellus ornare, auctor arcu vehicula bibendum habitasse sodales hac pretium, placerat turpis purus lacus lobortis pulvinar. Libero mi aptent vestibulum nostra nisi venenatis tristique, et feugiat porttitor laoreet dapibus nisl semper, pretium montes massa dictum maecenas faucibus. Penatibus odio iaculis dictumst cum magnis arcu ridiculus, per quisque condimentum justo inceptos est, auctor luctus phasellus senectus augue tortor.</p> ",
            " <p>Dictum commodo blandit ornare nibh dictumst ligula, aliquet mattis bibendum volutpat a eleifend, per purus quam sollicitudin taciti. Tempus viverra pretium magna penatibus vivamus id donec montes phasellus, fusce tortor aliquet fermentum eleifend feugiat leo vel placerat, platea lobortis gravida rutrum ad morbi risus bibendum. Laoreet sagittis cursus egestas sociis sapien lectus conubia tincidunt ut volutpat curae platea malesuada aliquam, tempus natoque at suscipit rhoncus vel potenti hac rutrum bibendum scelerisque senectus.</p> ",
            " <p>Purus nullam eget porta ridiculus neque odio, fermentum fames ante laoreet phasellus dignissim, class ullamcorper fusce eros tincidunt. Tellus elementum ultrices nostra interdum donec quisque habitasse aliquet morbi commodo, accumsan non lectus sociis diam tempor himenaeos mattis faucibus, pellentesque phasellus augue pharetra ante arcu magna tortor netus. Posuere taciti magna curabitur hendrerit nostra tincidunt turpis nisi parturient, erat litora elementum magnis eu bibendum a placerat in, ornare consequat dictum porttitor libero luctus fusce suscipit.</p> ",
            " <p>Mi vel aliquet cras posuere metus viverra sociis diam parturient egestas facilisis ante augue, netus aliquam consequat a primis quisque donec potenti dui molestie suscipit curabitur. Placerat ad arcu aenean pharetra mus ultrices cras donec sociosqu rhoncus penatibus, mauris accumsan rutrum vivamus urna primis duis gravida sollicitudin. Maecenas nostra nullam cubilia tortor metus himenaeos torquent faucibus ultricies interdum molestie senectus lectus, suspendisse sed laoreet euismod blandit ullamcorper tellus neque eros non luctus venenatis porttitor volutpat, proin porta cras platea mus fermentum at ornare etiam risus imperdiet aptent. Nisi ante pharetra mi sociis et tempor primis vulputate aptent tempus, aenean mollis pretium cum venenatis erat turpis cras varius.</p> ",
            " <p>Sociosqu torquent litora parturient magnis morbi condimentum mollis augue ad libero, est luctus nulla a taciti conubia curabitur class netus eros facilisis, vel placerat per ultricies mattis sagittis cubilia leo quisque. Eget facilisis litora faucibus mi curabitur suspendisse nostra, praesent tempus vel tempor per integer feugiat, luctus sodales donec habitant taciti nunc. Interdum enim at ut malesuada lacinia, scelerisque posuere egestas odio dui suscipit, eget porttitor viverra rutrum. Quis litora porttitor dapibus blandit augue eleifend fusce montes vulputate, inceptos rutrum nec platea feugiat suscipit in sodales laoreet, faucibus phasellus ultrices tristique a pulvinar maecenas at.</p> ",
            " <p>Facilisis vitae torquent tincidunt ultrices maecenas suspendisse eu risus curae molestie, curabitur ullamcorper imperdiet vestibulum primis dui mi per. Odio fusce per platea torquent litora auctor diam nascetur, nec rutrum vel interdum et ultricies nam tempus erat, facilisis dictum dignissim vestibulum porta eu purus.</p> ",
            " <p>Rutrum cras id purus tempus vivamus dictum malesuada eleifend dapibus himenaeos, ac luctus ligula natoque varius mattis lobortis mi. Class nascetur risus a non primis purus sociosqu luctus vel fermentum nunc commodo, eget at turpis cum porttitor pharetra ac cras dapibus sociis. Integer facilisi habitant aenean ultrices dignissim congue mi, in eu tellus arcu etiam aliquet, dapibus ante parturient diam imperdiet feugiat.</p> ",
            " <p>Fusce quisque maecenas a hendrerit fermentum nulla hac ac rutrum ornare, mi imperdiet massa erat dui eros mattis porta vehicula, ultrices turpis molestie egestas enim cursus mauris cum sapien. Nisi arcu et himenaeos litora morbi id augue faucibus sodales, congue nec dignissim libero fermentum molestie egestas facilisi, volutpat enim massa curae feugiat leo viverra proin. Pharetra leo tristique urna elementum primis convallis sollicitudin aliquet fusce volutpat, ac porttitor tellus euismod vulputate interdum duis nisi non egestas, quis ornare lectus sociis accumsan posuere massa montes praesent. Tempor sapien facilisis mi nascetur neque, taciti phasellus tellus ante nulla, netus donec purus nostra.</p> "
        ];

        return $paragraphs[rand(0, 9)];
    }
}
