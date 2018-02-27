<?php

use App\Stock;
use Illuminate\Database\Seeder;

class BVMFStocksSeed extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->bvmf_stocks); $i++) {
        	Stock::create([
        		'exchange' => 'BVMF',
        		'symbol' => $this->bvmf_stocks[$i]
        	]);
        }
    }

    public $bvmf_stocks = [
'ELEK3',
'CLSC3',
'RSUL4',
'RPAD3',
'FNAM11',
'DOMC11',
'MWET4',
'EMAE4',
'RBCB11',
'UNIP5',
'HGJH11',
'SAPR3',
'UNIP6',
'CTNM4',
'BMEB4',
'BMIN4',
'ALMI11',
'RPAD6',
'VLOL11',
'PABY11',
'RANI4',
'IRBR3',
'BMLC11B',
'UNIP3',
'BRKM3',
'RDES11',
'WHRL3',
'TGMA3',
'ARMT34',
'ONEF11',
'BNFS11',
'VIVT3',
'BPAN4',
'TUPY3',
'CBOP11',
'EKTR4',
'KNRE11',
'VLID3',
'MMXM11',
'WPLZ11B',
'GEPA3',
'HCRI11',
'BRGE3',
'HOOT4',
'CESP3',
'LOGN3',
'JPMC34',
'LUPA3',
'GRND3',
'FJTA4',
'IGBR3',
'CREM3',
'FEXC11',
'FIXX11',
'KNRI11',
'BCIA11',
'SCPF11',
'SHOW3',
'RBVO11',
'BAZA3',
'PMAM3',
'KLBN11',
'AAPL34',
'BRGE11',
'FJTA3',
'BEES4',
'VIVR3',
'PEAB3',
'RNEW3',
'BKBR3',
'CAML3',
'FLMA11',
'COCE5',
'OFSA3',
'HOME34',
'LLIS3',
'PQDP11',
'FVBI11',
'HGCR11',
'CPTS11B',
'VALE3',
'FAMB11B',
'JSRE11',
'BBRC11',
'WSON33',
'USIM3',
'DISB34',
'ALPA3',
'CNES11',
'BCRI11',
'FIGS11',
'ABCB4',
'CESP5',
'CGRA3',
'BBPO11',
'KNCR11',
'ITLC34',
'NSLU11',
'RNDP11',
'ADHM3',
'BAHI3',
'BIOM3',
'BSEV3',
'CPRE3',
'CSAB3',
'CXCE11B',
'CZLT33',
'DRIT11B',
'ELEK4',
'ELET3',
'ETER3',
'FLRP11',
'FNOR11',
'FPAB11',
'GPIV33',
'IDNT3',
'IDVL4',
'MNPR3',
'PINE4',
'PLRI11',
'PTNT4',
'REDE3',
'RNEW11',
'TAEE3',
'TBOF11',
'TCNO3',
'TCSA3',
'PNVL4',
'CMCS34',
'RBRD11',
'FFCI11',
'XPOM11',
'MNDL3',
'EDGA11',
'SNSL3',
'DAGB33',
'CXTL11',
'SGPS3',
'TRXL11',
'CPFE3',
'PFRM3',
'GRLV11',
'RADL3',
'KNIP11',
'CGAS3',
'BPAC11',
'XPCM11',
'MXRF11',
'BRCR11',
'ELET6',
'VAGR3',
'MGEL4',
'HTMX11',
'AEFI11',
'MCDC34',
'KLBN4',
'WALM34',
'RBGS11',
'SAAG11',
'MATB11',
'BDLL4',
'OSXB3',
'TRIS3',
'EURO11',
'LEVE3',
'BBVJ11',
'RAIL3',
'ENGI11',
'JRDM11',
'PRSV11',
'MBRF11',
'ABCP11',
'ALUP11',
'BEES3',
'RCSL4',
'CEOC11',
'OMGE3',
'FDMO34',
'SMTO3',
'LINX3',
'RBBV11',
'BBDC4',
'PRML3',
'JSLG3',
'ALPA4',
'AGCX11',
'MSFT34',
'KEPL3',
'BRKM5',
'SUZB3',
'SANB4',
'FRAS3',
'MTSA4',
'GBIO33',
'HGLG11',
'TWXB34',
'RAPT3',
'BEEF3',
'CSAN3',
'BRAP3',
'NATU3',
'UCAS3',
'MRCK34',
'WIZS3',
'SHPH11',
'LAME4',
'CVCB3',
'PTBL3',
'MILS3',
'RANI3',
'FIIB11',
'PDGR3',
'RNGO11',
'GEPA4',
'ECOO11',
'SDIL11',
'HGBS11',
'BBFI11B',
'MMXM3',
'ITUB3',
'CTAX3',
'AMAR3',
'BBRK3',
'CLSC4',
'CESP6',
'CTNM3',
'HAGA4',
'TAEE11',
'TPIS3',
'WEGE3',
'JBSS3',
'BPFF11',
'SCAR3',
'ITSA3',
'BMKS3',
'EQTL3',
'AELP3',
'SBUB34',
'RLOG3',
'VISA34',
'VIVT4',
'KLBN3',
'TRPN3',
'MOAR3',
'THRA11',
'OGXP3',
'SHUL4',
'MRVE3',
'VRTA11',
'ARZZ3',
'ATOM3',
'FCFL11',
'MAGG3',
'MMMC34',
'LMTB34',
'EGIE3',
'AGRO3',
'ENEV3',
'MDIA3',
'AZUL4',
'ALSC3',
'DASA3',
'FHER3',
'BRAP4',
'SAPR4',
'ABEV3',
'MRFG3',
'GOVE11',
'EZTC3',
'SLCE3',
'CCRO3',
'DIVO11',
'ISUS11',
'HBOR3',
'IVVB11',
'BBSE3',
'RENT3',
'CXRI11',
'TIET4',
'VVAR3',
'BRAX11',
'BMYB34',
'AALR3',
'ELPL3',
'RNEW4',
'LCAM3',
'RDNI3',
'FIND11',
'ROMI3',
'SMAL11',
'CMIG3',
'ODPV3',
'PIBB11',
'TOTS3',
'EMBR3',
'CSMG3',
'AXPB34',
'BRSR6',
'SEDU3',
'JNJB34',
'CRFB3',
'TIET11',
'BOVA11',
'XTED11',
'CHVX34',
'LIGT3',
'BRSR3',
'MEAL3',
'UGPA3',
'ABTT34',
'FAED11',
'PSSA3',
'CMIG4',
'HGRE11',
'RPMG3',
'PARD3',
'GPCP3',
'ITSA4',
'CTGP34',
'LAME3',
'GUAR3',
'BTTL4',
'ECPR3',
'MYPK3',
'TEKA4',
'IGTA3',
'BBDC3',
'ITUB4',
'HYPE3',
'FIBR3',
'MPLU3',
'PCAR4',
'PRIO3',
'BRGE6',
'COLG34',
'VULC3',
'ESTC3',
'TRPL4',
'TIMP3',
'GFSA3',
'RCSL3',
'PORD11',
'TIET3',
'MULT3',
'SEER3',
'QUAL3',
'PFIZ34',
'CCPR3',
'ORCL34',
'RSID3',
'TAEE4',
'BOBR4',
'JHSF3',
'GUAR4',
'POSI3',
'ECOR3',
'SSBR3',
'USIM5',
'SBSP3',
'EUCA4',
'BTOW3',
'ENBR3',
'CYRE3',
'HGTX3',
'JBDU4',
'MFII11',
'BBAS3',
'JFEN3',
'VVAR4',
'BRIV3',
'CGAS5',
'SANB11',
'GOLL4',
'EXXO34',
'AMZO34',
'SMLS3',
'CARD3',
'KROT3',
'POMO4',
'STBP3',
'SPTW11',
'CPLE6',
'DTEX3',
'BRML3',
'BOAC34',
'CTXT11',
'TECN3',
'DIRR3',
'CPLE3',
'SANB3',
'POMO3',
'BRIV4',
'SULA11',
'LREN3',
'TOYB3',
'CIEL3',
'JBDU3',
'CGRA4',
'PETR4',
'TELB4',
'BRPR3',
'OIBR4',
'TEND3',
'BRDT3',
'MGLU3',
'GGBR3',
'VVAR11',
'ANIM3',
'MOVI3',
'TCNO4',
'FIIP11B',
'BVMF3',
'GSHP3',
'GGBR4',
'TOYB4',
'BRFS3',
'SLED4',
'PETR3',
'FLRY3',
'LPSB3',
'FESA4',
'BPHA3',
'CCXC3',
'OIBR3',
'GOAU3',
'BRIN3',
'GOAU4',
'EVEN3',
'CSNA3',
'RAPT4',
'QGEP3',
'SOND5',
'SLED3',
'FMOF11',
'WFCO34',
'CEDO4',
'CTKA4',
'SAPR11'];
}